<?php
require 'clases/conexion.php';

$pedido_id = $_POST['pedido_id']; // Recibe el id_pedido por POST

$response = []; // Array para la respuesta

if ($pedido_id) {
    // Obtener detalles del pedido
    $detalles = consultas::get_datos("SELECT art_cod, art_descri, ord_cant 
        FROM v_control_produccion_detalles 
        WHERE pedido_id = $pedido_id");

    $detalle_html = '';
    $etapas_html = '';

    if ($detalles) {
        foreach ($detalles as $detalle) {
            // Generar HTML para los detalles de los artículos
            $detalle_html .= '<tr>
                <td>
                    <input type="hidden" name="vart_cod[]" value="' . htmlspecialchars($detalle['art_cod']) . '">
                    ' . htmlspecialchars($detalle['art_descri']) . '
                </td>
                <td>
                    <input type="hidden" name="vcantidad[]" value="' . htmlspecialchars($detalle['ord_cant']) . '">
                    ' . htmlspecialchars($detalle['ord_cant']) . '
                </td>
            </tr>';

            // Obtener las etapas asociadas al artículo
            $etapas = consultas::get_datos("SELECT id_etapa, nombre_etapa, descripcion, orden 
                FROM articulo_etapas 
                WHERE art_cod = {$detalle['art_cod']} 
                ORDER BY orden ASC");

            if ($etapas) {
                foreach ($etapas as $etapa) {
                    $etapas_html .= '<tr>
                        <td>' . htmlspecialchars($detalle['art_descri']) . '</td>
                        <td>' . htmlspecialchars($etapa['nombre_etapa']) . '</td>
                        <td>' . htmlspecialchars($etapa['descripcion'] ?? 'Sin descripción') . '</td>
                        <td>
                            <input type="checkbox" name="vestado_etapa[' . htmlspecialchars($etapa['id_etapa']) . ']" value="8">
                            Cumplido
                        </td>
                    </tr>';
                }
            }
        }
    } else {
        $detalle_html = '<tr><td colspan="2">No se encontraron detalles para este pedido.</td></tr>';
        $etapas_html = '<tr><td colspan="4">No se encontraron etapas para los artículos del pedido.</td></tr>';
    }

    // Preparar la respuesta
    $response = [
        'detalles' => $detalle_html,
        'etapas' => $etapas_html
    ];
}

// Enviar respuesta en formato JSON
echo json_encode($response);
?>
