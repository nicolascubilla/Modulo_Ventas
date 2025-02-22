<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Elimina espacios en blanco y asegura que exista 'query'

if (!empty($query)) {
    // Consulta filtrando solo por ID del pedido
    $pedido = consultas::get_datos("SELECT pedido_id, art_cod, art_descri, ord_cant
        FROM v_control_produccion_detalles 
        WHERE pedido_id = '$query'");

    if (!empty($pedido)) {
        foreach ($pedido as $pedi) { ?>
            <option value="<?php echo htmlspecialchars($pedi['pedido_id']); ?>">
                <?php echo "N°: " . htmlspecialchars($pedi['pedido_id']); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No se encontraron pedidos de materia prima.</option>';
    }
} else {
    echo '<option value="">Ingrese un ID de la orden válido.</option>';
}
