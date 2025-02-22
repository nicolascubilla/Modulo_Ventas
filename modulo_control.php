<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_modulos(".$_REQUEST['accion'].",".$_REQUEST['vmod_cod'].",'".$_REQUEST['vmod_nombre']."') as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:modulo_index.php");
} else {
    $_SESSION['mensaje'] = "Error al procesar \n".$sql;
    header("location:modulo_index.php");
}