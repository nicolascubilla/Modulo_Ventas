<?php

require 'clases/conexion.php';


$sql ="select sp_paginas(".$_REQUEST['accion'].",
".(!empty($_REQUEST['vpag_cod'])?$_REQUEST['vpag_cod']:"0").", 
'".(!empty($_REQUEST['vpag_direc'])?$_REQUEST['vpag_direc']:"")."', 
'".(!empty($_REQUEST['vpag_nombre'])?$_REQUEST['vpag_nombre']:"")."', 
".(!empty($_REQUEST['vmod_cod'])?$_REQUEST['vmod_cod']:"0").") as resul";

//echo $sql;
session_start();
$resultado= consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:pagina_index.php");
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:pagina_index.php");    
}