<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Elimina espacios en blanco y asegura que exista 'query'

if (!empty($query)) {
    // Consulta filtrando solo por ID del pedido
    $control = consultas::get_datos("SELECT control_id, art_cod,
    art_descri,
    cantidad
        FROM v_listar_detalles_produccion 
        WHERE control_id = '$query'");

    if (!empty($control)) {
        foreach ($control as $con) { ?>
            <option value="<?php echo htmlspecialchars($con['control_id']); ?>">
                <?php echo "N°: " . htmlspecialchars($con['control_id']); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No se encontraron producciónes.</option>';
    }
} else {
    echo '<option value="">Ingrese un ID de la producción válido.</option>';
}
