<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Elimina espacios en blanco y asegura que exista 'query'

if (!empty($query)) {
    // Consulta filtrando solo por ID del pedido
    $pedidos = consultas::get_datos("SELECT id_pedido, material, cantidad 
        FROM v_presupuesto_pedido_compra_detalle 
        WHERE  id_pedido = '$query'");

    if (!empty($pedidos)) {
        foreach ($pedidos as $pedido) { ?>
            <option value="<?php echo htmlspecialchars($pedido['id_pedido']); ?>">
                <?php echo "N°: " . htmlspecialchars($pedido['id_pedido']); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No se encontraron pedidos.</option>';
    }
} else {
    echo '<option value="">Ingrese un ID de pedido válido.</option>';
}
