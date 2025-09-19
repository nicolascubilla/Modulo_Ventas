<?php
require 'clases/conexion.php';
$dep_cod = $_POST['dep_cod'];

$sql = "SELECT m.material_id, m.nombre_material, 
               SUM(sm.cantidad_disponible) as existencia, 
               0 as encontrada
        FROM stock_material sm
        JOIN material m ON sm.material_id = m.material_id
        WHERE sm.dep_cod = $dep_cod
        GROUP BY m.material_id, m.nombre_material
        ORDER BY m.nombre_material";

$result = consultas::get_datos($sql);

echo json_encode($result);
?>

