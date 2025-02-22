<?php

require 'clases/conexion.php';
session_start();
//var_dump($_REQUEST);

$sql= "select sp_compras_det(
".$_REQUEST['accion'].",
".$_REQUEST['vcom_cod'].",
".$_REQUEST['vdep_cod'].",
split_part('".$_REQUEST['vart_cod']."','_',1)::integer,
".(!empty($_REQUEST['vcom_cant'])?$_REQUEST['vcom_cant']:"0").",
".(!empty($_REQUEST['vcom_precio'])?$_REQUEST['vcom_precio']:"0").")as resul";

$resultado= consultas::get_datos($sql);

if($resultado[0]['resul']!=null){
    $_SESSION['mensaje']=$resultado[0]['resul'];
    header("location:compras_det.php?vcom_cod=".$_REQUEST['vcom_cod']);
}else{
    $_SESSION['mensaje']="Error al procesar ".$sql;
    header("location:compras_det.php?vcom_cod=".$_REQUEST['vcom_cod']);
}

