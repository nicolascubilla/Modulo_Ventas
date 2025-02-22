<?php 

require 'clases/conexion.php';
//var_dump($_REQUEST);
session_start();

$sql="select*from sp_articulo(
".$_REQUEST['accion'].",
".$_REQUEST['vart_cod'].",
'".(!empty($_REQUEST['vart_codbarra'])?$_REQUEST['vart_codbarra']:"0")."',
".(!empty($_REQUEST['vmar_cod'])?$_REQUEST['vmar_cod']:"0").",
'".$_REQUEST['vart_descri']."',
".(!empty($_REQUEST['vart_precioc'])?$_REQUEST['vart_precioc']:"0").",
".(!empty($_REQUEST['vart_preciov'])?$_REQUEST['vart_preciov']:"0").",
".(!empty($_REQUEST['vtipo_cod'])?$_REQUEST['vtipo_cod']:"0").")as resul";

$resultado= consultas::get_datos($sql);

if($resultado[0]['resul']!=null){
    $valor= explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error al procesar".$sql;
    header("location:articulos_index.php");
}

