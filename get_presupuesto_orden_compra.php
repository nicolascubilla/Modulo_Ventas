<?php
require 'clases/conexion.php';

$presupuesto_id = $_POST['presupuesto_id']; // Recibe el id_pedido por POST

$response = []; // Array para la respuesta

if ($presupuesto_id) {
    // Obtener razón social del proveedor
    $cabecera = consultas::get_datos("SELECT  prv_cod, prv_razonsocial FROM v_orden_select_presupuesto_compra WHERE presupuesto_id = $presupuesto_id LIMIT 1");

    // Obtener detalles del presupuesto
    $detalles = consultas::get_datos("SELECT material_id, material, cantidad, costo_unitario, subtotal 
        FROM v_orden_select_presupuesto_compra
        WHERE presupuesto_id = $presupuesto_id");

    // Generar HTML para los detalles
    $detalle_html = '';
    if ($detalles) {
        foreach ($detalles as $detalle) {
            $detalle_html .= '<tr>
                <td>
                    <input type="hidden" name="material_id[]" value="' . htmlspecialchars($detalle['material_id']) . '">
                    ' . htmlspecialchars($detalle['material']) . '
                </td>
                <td>
                    <input type="hidden" name="cantidad_material[]" value="' . htmlspecialchars($detalle['cantidad']) . '">
                    ' . htmlspecialchars($detalle['cantidad']) . '
                </td>
                <td>
                    <input type="hidden" name="costo_unitario[]" value="' . htmlspecialchars($detalle['costo_unitario']) . '">
                    ' .number_format($detalle['costo_unitario']) . '
                </td>
                  <td>
                    <name="subtotal" value="' . htmlspecialchars($detalle['subtotal']) . '">
                    ' .number_format($detalle['subtotal']) . '
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
    'razon_social' => $cabecera[0]['prv_razonsocial'] ?? '', // Nombre del proveedor
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
