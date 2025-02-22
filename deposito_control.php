<?php

require 'clases/conexion.php';


$sql ="select sp_deposito(".$_REQUEST['accion'].",
".(!empty($_REQUEST['vdep_cod'])?$_REQUEST['vdep_cod']:"0").", 
'".(!empty($_REQUEST['vdep_descri'])?$_REQUEST['vdep_descri']:"")."', 
".(!empty($_REQUEST['vid_sucursal'])?$_REQUEST['vid_sucursal']:"0").") as resul";

//echo $sql;
session_start();
$resultado= consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:deposito_index.php");
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:deposito_index.php");    
}