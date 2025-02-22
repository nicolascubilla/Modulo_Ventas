<?php

require 'clases/conexion.php';
session_start();

$sql = "SELECT sp_detalle_presupuesto(
".$_REQUEST['accion'].",
".$_REQUEST['vpre_cod'].", 
".$_REQUEST['vdep_cod'].", 
split_part('".$_REQUEST['vart_cod']."', '_', 1)::integer, 
".(!empty($_REQUEST['vpre_cant'])? $_REQUEST['vpre_cant'] : "0").", 
".(!empty($_REQUEST['vpre_precio'])? $_REQUEST['vpre_precio'] : "0").") AS resul";

//echo $sql;

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:presupuesto_det.php?vpre_cod=".$_REQUEST['vpre_cod']);
}else{
    $_SESSION['mensaje'] = "Error al procesar \n".$sql;
    header("location:presupuesto_det.php?vpre_cod=".$_REQUEST['vpre_cod']);    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

