<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_grupos(".$_REQUEST['accion'].",".$_REQUEST['vgru_cod'].",'".$_REQUEST['vgru_nombre']."') as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:grupo_index.php");
} else {
    $_SESSION['mensaje'] = "Error al procesar \n".$sql;
    header("location:grupo_index.php");
}