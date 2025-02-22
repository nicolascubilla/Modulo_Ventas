<?php
require 'clases/conexion.php';

$orden_id = $_POST['orden_id']; // Recibe el id_pedido por POST

$response = []; // Array para la respuesta

if ($orden_id) {
    // Obtener razón social del proveedor
    $cabecera = consultas::get_datos("SELECT  prv_cod, proveedor, total FROM v_listar_orden_compra WHERE orden_id = $orden_id LIMIT 1");

    // Obtener detalles del presupuesto
    $detalles = consultas::get_datos("SELECT material_id, nombre_material, cantidad, costo_unitario, subtotal 
        FROM v_listar_orden_compra
        WHERE orden_id = $orden_id");

    // Generar HTML para los detalles
    $detalle_html = '';
    if ($detalles) {
        foreach ($detalles as $detalle) {
            $detalle_html .= '<tr>
                <td>
                    <input type="hidden" name="vmaterial_id[]" value="' . htmlspecialchars($detalle['material_id']) . '">
                    ' . htmlspecialchars($detalle['nombre_material']) . '
                </td>
                <td>
                    <input type="hidden" name="vcantidad_material[]" value="' . htmlspecialchars($detalle['cantidad']) . '">
                    ' . htmlspecialchars($detalle['cantidad']) . '
                </td>
                <td>
                    <input type="hidden" name="vcosto_unitario[]" value="' . htmlspecialchars($detalle['costo_unitario']) . '">
                    ' .number_format($detalle['costo_unitario']) . '
                </td>
                  <td>
                    <input type="hidden" name="vsubtotal[]" value="' . htmlspecialchars($detalle['subtotal']) . '">
                    ' .number_format($detalle['subtotal']) . '
                    
                </td>  
           
 <td>
    <input type="number" name="viva_5[]" class="form-control"  placeholder="Ingrese el monto del IVA 5%">
</td>
 <td>
    <input type="number" name="viva_10[]" class="form-control"  placeholder="Ingrese el monto del IVA 10%">
</td>




            </tr>';
        }
    } else {
        $detalle_html = '<tr><td colspan="3">No se encontraron detalles para este presupuesto.</td></tr>';
    }

    // Preparar respuesta
   // Preparar respuesta
$response = [
    'prv_cod' => $cabecera[0]['prv_cod'] ?? '', // Incluye el código del proveedor
    'razon_social' => $cabecera[0]['proveedor'] ?? '', // Nombre del proveedor
    'detalles' => $detalle_html,
    'total' => $cabecera[0]['total'] ?? '', 
    'detalles' => $detalle_html
    
];

} else {
    $response = [
        'razon_social' => '',
        'detalles' => '<tr><td colspan="3">Debe seleccionar un presupuesto.</td></tr>'
    ];
}

// Enviar respuesta en formato JSON
echo json_encode($response);
?>
