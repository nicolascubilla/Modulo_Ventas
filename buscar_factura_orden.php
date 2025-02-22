<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Elimina espacios en blanco y asegura que exista 'query'

if (!empty($query)) {
    // Consulta filtrando solo por ID del pedido
    $presupuestos = consultas::get_datos("SELECT orden_id, nombre_material, cantidad, subtotal 
        FROM v_listar_orden_compra 
        WHERE  orden_id = '$query'");

    if (!empty($presupuestos)) {
        foreach ($presupuestos as $presu) { ?>
            <option value="<?php echo htmlspecialchars($presu['orden_id']); ?>">
                <?php echo "N°: " . htmlspecialchars($presu['orden_id']); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No se encontraron ordenes de compras.</option>';
    }
} else {
    echo '<option value="">Ingrese un ID de la orden válido.</option>';
}
