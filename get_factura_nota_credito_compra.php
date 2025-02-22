<?php
require 'clases/conexion.php';

$id_factura = $_POST['id_factura'] ?? null;

$response = [];
if ($id_factura) {
    $cabecera = consultas::get_datos("SELECT id_factu_proveedor, prv_razonsocial, monto_total, timbrado 
        FROM v_nota_credito 
        WHERE id_factura = $id_factura 
        LIMIT 1");

    $detalles = consultas::get_datos("SELECT nro_cuota, monto_cuota, fecha_vencimiento, saldo_cuota , estado_pago
        FROM v_cuentas_a_pagar 
        WHERE id_factura = $id_factura");

    $detalle_html = '';
    if ($detalles) {
        foreach ($detalles as $detalle) {
            $detalle_html .= "<tr>
            <td>{$detalle['nro_cuota']}</td>
            <td>" . number_format($detalle['monto_cuota']) . "</td>
            <td>{$detalle['fecha_vencimiento']}</td>
            <td>" . number_format($detalle['saldo_cuota']) . "</td>
            <td>{$detalle['estado_pago']}</td>
        </tr>";
        
    }
} else {
        $detalle_html = '<tr><td colspan="5">No se encontraron detalles para esta factura.</td></tr>';
    }

    $response = [
        'razon_social' => $cabecera[0]['prv_razonsocial'] ?? '',
        'id_factu_proveedor' => $cabecera[0]['id_factu_proveedor'] ?? '',
        'total' => number_format($cabecera[0]['monto_total']) ?? '',
        'timbrado' => $cabecera[0]['timbrado'] ?? '',
        'detalles' => $detalle_html,
    ];
} else {
    $response = [
        'razon_social' => '',
        'id_factu_proveedor' => '',
        'total' => '',
        'timbrado' => '',
        'detalles' => '<tr><td colspan="5">Debe seleccionar una factura.</td></tr>',
    ];
}

echo json_encode($response);
?>
