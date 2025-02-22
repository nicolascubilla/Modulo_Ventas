<?php

require 'clases/conexion.php';
session_start();
$sql = "select sp_cliente(".$_REQUEST['accion'].","
        .$_REQUEST['vcli_cod'].",".$_REQUEST['vcli_ci'].",'".$_REQUEST['vcli_nombre']."','".$_REQUEST['vcli_apellido']."','".$_REQUEST['vcli_telefono']."',"
        . "'".$_REQUEST['vcli_direcc']."') as resul";

$resultado = consultas::get_datos($sql);

if($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:clientes_index.php");
} else {
    $_SESSION['mensaje'] = 'Error al procesar \n '.$sql;
    header("location:clientes_index.php");
}
