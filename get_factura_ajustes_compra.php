<?php
require 'clases/conexion.php';

$id_factura = $_POST['id_factura']; // Recibe el id_factura por POST
$response = []; // Array para la respuesta

if ($id_factura) {
    // Obtener datos de la cabecera de la factura
    $cabecera = consultas::get_datos("SELECT id_factu_proveedor, proveedor, sucursal_descripcion, usuario_nick, timbrado, condicion 
        FROM v_factura_compra_cabecera_detalle 
        WHERE id_factura = $id_factura 
        LIMIT 1");

    // Obtener detalles de la factura
    $detalles = consultas::get_datos("SELECT material_id, nombre_material, cantidad, costo_unitario, subtotal 
        FROM v_factura_compra_cabecera_detalle 
        WHERE id_factura = $id_factura");

    // Generar HTML para los detalles
    $detalle_html = '';
    if ($detalles) {
        foreach ($detalles as $detalle) {
            $detalle_html .= '<tr>
                <td>
                    <input type="hidden" name="vmaterial_id[]" value="' . htmlspecialchars($detalle['material_id']) . '">
                    ' . htmlspecialchars($detalle['nombre_material']) . '
                </td>
               <td>' . htmlspecialchars($detalle['cantidad']) . '</td>
                <td>
                    <input type="number" name="cantidad_ajustada[]" 
                           class="form-control" required 
                           placeholder="Ingrese la cantidad a ajustar">
                </td>

                <td>' . number_format($detalle['costo_unitario']) . '</td>
                <td>' . number_format($detalle['subtotal']) . '</td>
            </tr>';
        }
    } else {
        $detalle_html = '<tr><td colspan="4">No se encontraron detalles para esta factura.</td></tr>';
    }

    // Preparar respuesta
    $response = [
        'proveedor' => $cabecera[0]['proveedor'] ?? '', // Nombre del proveedor
        'id_factu_proveedor' => $cabecera[0]['id_factu_proveedor'] ?? '', // Nombre del proveedor
        'sucursal' => $cabecera[0]['sucursal_descripcion'] ?? '', // Nombre del proveedor
        'vtimbrado' => $cabecera[0]['timbrado'] ?? '', // Nombre del proveedor
        'vcondicion' => $cabecera[0]['condicion'] ?? '', // Nombre del proveedor
        'detalles' => $detalle_html, // HTML generado
    ];
} else {
    $response = [
        'proveedor' => '',
        'detalles' => '<tr><td colspan="4">Debe seleccionar una factura.</td></tr>',
    ];
}

// Enviar respuesta en formato JSON
echo json_encode($response);
?>
