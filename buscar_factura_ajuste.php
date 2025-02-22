<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Elimina espacios en blanco y asegura que exista 'query'

if (!empty($query)) {
    // Consulta filtrando solo por ID del pedido
    $factura = consultas::get_datos("
    SELECT id_factura, proveedor 
    FROM v_factura_compra_cabecera_detalle 
    WHERE id_factura = '$query'");


if (!empty($factura)) {
    foreach ($factura as $fact) { ?>
        <option value="<?php echo htmlspecialchars($fact['id_factura']); ?>">
            <?php echo "N°: " . htmlspecialchars($fact['id_factura']) . " - " . htmlspecialchars($fact['proveedor']); ?>
        </option>
    <?php }
} else {
    echo '<option value="">No se encontraron facturas con ese ID.</option>';
}

}
