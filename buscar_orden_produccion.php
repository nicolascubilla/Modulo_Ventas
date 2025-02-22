<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Asegura que exista query

if (!empty($query)) {
    $ordenes = consultas::get_datos("
        SELECT ord_cod, fecha FROM v_listar_orden_pendientes WHERE ord_cod = '$query'
    ");

    if (!empty($ordenes)) {
        foreach ($ordenes as $orden) {
            echo '<option value="' . htmlspecialchars($orden['ord_cod']) . '">';
            echo 'N°: ' . htmlspecialchars($orden['ord_cod']) . ' - Fecha: ' . htmlspecialchars($orden['fecha']);
            echo '</option>';
        }
    } else {
        echo '<option value="">No se encontraron órdenes con ese ID.</option>';
    }
} else {
    echo '<option value="">Por favor ingrese un ID de orden.</option>';
}
?>


