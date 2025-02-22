<?php 

require 'clases/conexion.php';
session_start();

try {
    // Construcción segura del SQL
    $accion = intval($_REQUEST['accion']);
    $vmaterial_id = isset($_REQUEST['vmaterial_id']) ? intval($_REQUEST['vmaterial_id']) : 'NULL';
    $vnombre_material = !empty($_REQUEST['vnombre_material']) ? "'".pg_escape_string($_REQUEST['vnombre_material'])."'" : 'NULL';
    $vdescripcion = !empty($_REQUEST['vdescripcion']) ? "'".pg_escape_string($_REQUEST['vdescripcion'])."'" : 'NULL';
    $vunidad_medida = !empty($_REQUEST['vunidad_medida']) ? "'".pg_escape_string($_REQUEST['vunidad_medida'])."'" : 'NULL';
    $vcosto_unitario = isset($_REQUEST['vcosto_unitario']) ? floatval($_REQUEST['vcosto_unitario']) : 'NULL';

    // Construcción de la consulta SQL
    $sql = "SELECT * FROM sp_material(
                $accion,
                $vmaterial_id,
                $vnombre_material,
                $vdescripcion,
                $vunidad_medida,
                $vcosto_unitario
            ) AS resul";

    // Ejecución de la consulta
    $resultado = consultas::get_datos($sql);

    if($resultado && $resultado[0]['resul'] != null){
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("Location: ".$valor[1]);
    } else {
        throw new Exception("Error al procesar: $sql");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = $e->getMessage();
    header("Location: material_index.php");
}

