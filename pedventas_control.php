<?php
require 'clases/conexion.php';
session_start();

$sql=" select sp_pedventas(
".$_REQUEST['accion'].",
".$_REQUEST['vped_cod'].",
".$_SESSION['emp_cod'].",
".(!empty($_REQUEST['vcli_cod'])?$_REQUEST['vcli_cod']:"0").",
".$_SESSION['id_sucursal'].") as resul";

$resultado = consultas::get_datos($sql);

if($resultado[0]['resul']!=null){
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:pedventas_index.php".$valor[1]);
}else{
    $_SESSION['mensaje'] = "Error al procesar \n".$sql;
    header("location:pedventas_index.php");    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

