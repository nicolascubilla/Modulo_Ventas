<?php
require 'clases/conexion.php';

$control_id = $_POST['control_id'];

$sql = "
    SELECT 
        art_cod, 
        art_descri, 
        pre_cant, 
        art_preciov,
        tipo_cod,
        tipo_descri,
        tipo_porcen as iva_porcentaje
    FROM v_ventas_aprobadas
    WHERE control_id = $control_id
";

$detalles = consultas::get_datos($sql);
echo json_encode($detalles);
?>