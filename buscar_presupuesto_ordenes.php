<?php
require 'clases/conexion.php';

$query = trim($_POST['query'] ?? ''); // Asegura que exista query

if (!empty($query)) {
    $presupuestos = consultas::get_datos("
    SELECT pre_cod, fecha_emision 
    FROM v_presupuestos_pendientes 
    WHERE pre_cod = '$query'");
    
    if (!empty($presupuestos)) {
        foreach ($presupuestos as $pre) { ?>
            <option value="<?php echo htmlspecialchars($pre['pre_cod']); ?>">
                <?php echo "N°: " . htmlspecialchars($pre['pre_cod']) . " - Fecha: " . htmlspecialchars($pre['fecha_emision']); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No se encontraron presupuestos con ese ID.</option>';
    }
}

