<?php
require 'clases/conexion.php';
$control_id = $_POST['control_id']; 
$response = [];
if ($control_id) {
    $detalles = consultas::get_datos("SELECT control_id, art_cod, art_descri,id_etapa,nombre_etapa, cantidad FROM v_listar_detalles_produccion WHERE control_id = $control_id");
    $estados = consultas::get_datos("SELECT id_estado, nombre FROM estado WHERE id_estado IN (4,9,10) ORDER BY id_estado ASC");
    $detalle_html = '';
    if ($detalles) {
        foreach ($detalles as $detalle) {
            $opciones_estado = '';
            foreach ($estados as $estado) {
                $opciones_estado .= '<option value="' . htmlspecialchars($estado['id_estado']) . '">' . htmlspecialchars($estado['nombre']) . '</option>';
            }
            $detalle_html .= '<tr>
                <td>
                    <input type="hidden" name="vart_cod[]" value="' . htmlspecialchars($detalle['art_cod']) . '">
                    ' . htmlspecialchars($detalle['art_descri']) . '
                </td>
                 <td>
                    <input type="hidden" name="vid_etapa[]" value="' . htmlspecialchars($detalle['id_etapa']) . '">
                    ' . htmlspecialchars($detalle['nombre_etapa']) . '
                </td>
                <td>
                    <input type="hidden" name="vcantidad[]" value="' . htmlspecialchars($detalle['cantidad']) . '">
                    ' . htmlspecialchars($detalle['cantidad']) . '
                </td>
                <td>
                    <select name="id_estado[]" class="form-control select2 estado" required onchange="toggleCantidad(this)">
                        <option value="">Seleccione un estado</option>
                        ' . $opciones_estado . '
                    </select>
                </td>
                <td>
                    <input type="number" name="vcantidad_rechazada[]" class="form-control cantidad-rechazada" min="0" step="1">
                </td>
                <td>
                    <input type="number" name="vcantidad_critica[]" class="form-control cantidad-critica" min="0" step="1">
                </td>
            </tr>';
        }
    }
    $response = ['detalles' => $detalle_html];
}
echo json_encode($response);
?>