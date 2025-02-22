<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Elimina espacios en blanco y asegura que exista 'query'

if (!empty($query)) {
    // Consulta filtrando solo por ID del pedido
    $presupuestos = consultas::get_datos("SELECT presupuesto_id, material, cantidad, subtotal 
        FROM v_orden_select_presupuesto_compra 
        WHERE  presupuesto_id = '$query'");

    if (!empty($presupuestos)) {
        foreach ($presupuestos as $presu) { ?>
            <option value="<?php echo htmlspecialchars($presu['presupuesto_id']); ?>">
                <?php echo "N°: " . htmlspecialchars($presu['presupuesto_id']); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No se encontraron pedidos.</option>';
    }
} else {
    echo '<option value="">Ingrese un ID de pedido válido.</option>';
}
