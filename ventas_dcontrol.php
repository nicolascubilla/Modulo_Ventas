<?php

require 'clases/conexion.php';
session_start();

//var_dump($_REQUEST);
$sql = "select sp_ventas_det(
".$_REQUEST['accion'].",
".$_REQUEST['vven_cod'].", 
".$_REQUEST['vdep_cod'].", 
split_part('".$_REQUEST['vart_cod']."','_',1)::integer, 
".(!empty($_REQUEST['vven_cant'])? $_REQUEST['vven_cant']:"0").", 
".(!empty($_REQUEST['vven_precio'])?$_REQUEST['vven_precio']:"0").") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:ventas_det.php?vven_cod=".$_REQUEST['vven_cod']);
}else{
    $_SESSION['mensaje'] = "Error al procesar \n".$sql;
    header("location:ventas_det.php?vven_cod=".$_REQUEST['vven_cod']);    
}
