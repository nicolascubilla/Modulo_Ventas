<?php

require 'clases/conexion.php';

$sql = "select sp_tipo(".$_REQUEST['accion'].",".$_REQUEST['vtipo_cod'].",'".$_REQUEST['vtipo_descri']."',".
        $_REQUEST['vtipo_porcen'].") as resul;";

session_start();
$resultado= consultas::get_datos($sql);

if($resultado[0]['resul']!=null){
    $_SESSION['mensaje']=$resultado[0]['resul'];
    header("location:tipoi_index.php");
}else{
    $_SESSION['mensaje']='Error:'.$sql;
    header("location:tipoi_index.php");
}


