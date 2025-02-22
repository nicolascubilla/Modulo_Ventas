<?php
require 'clases/conexion.php';

$id_pedido = $_POST['id_pedido']; // Recibe el id_pedido por POST

if ($id_pedido) {
    // Realizar la consulta para obtener el detalle del pedido
    $detalles = consultas::get_datos("SELECT material_id, material, cantidad 
        FROM v_presupuesto_pedido_compra_detalle
        WHERE id_pedido = $id_pedido");

    if ($detalles) {
        // Generar las filas de la tabla con los detalles
        foreach ($detalles as $detalle) { ?>
            <tr>
                <!-- Campo oculto para enviar el material_id -->
                <td>
                    <input type="hidden" name="material_id[]" value="<?php echo htmlspecialchars($detalle['material_id']); ?>">
                    <?php echo htmlspecialchars($detalle['material']); ?>
                </td>
                
                <!-- Campo oculto para enviar la cantidad -->
                <td>
                    <input type="hidden" name="cantidad_material[]" value="<?php echo htmlspecialchars($detalle['cantidad']); ?>">
                    <?php echo htmlspecialchars($detalle['cantidad']); ?>
                </td>
                
                <!-- Campo editable para el costo unitario -->
                <td>
                    <input type="number" name="costo_unitario[]" 
                           class="form-control" required 
                           placeholder="Ingrese el costo unitario">
                </td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="3">No se encontraron detalles para este pedido.</td>
        </tr>
    <?php }
} else { ?>
    <tr>
        <td colspan="3">Debe seleccionar un pedido.</td>
    </tr>
    
<?php }
?>
