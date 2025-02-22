<?php

require 'clases/conexion.php';



$sql = "select * from v_usuarios "
       . "where usu_nick ='".$_REQUEST['usuario']
        ."'and usu_clave = md5 ('" .$_REQUEST ['clave']."')";

$resultado = consultas::get_datos($sql);
session_start();
//var_dum ($resultado);
if ($resultado[0]['usu_cod']==null){
    $_SESSION ['error'] ="usuario o conraseña incorrectos";
    header("location:index.php");
}else{
    $_SESSION ['usu_cod'] = $resultado[0]['usu_cod'];
    $_SESSION ['usu_nick'] = $resultado[0]['usu_nick'];
    $_SESSION ['usu_fot'] = '';
    $_SESSION ['emp_cod'] = $resultado[0]['emp_cod'];
    $_SESSION ['nombres'] = $resultado[0]['empleado'];
    $_SESSION ['gru_cod'] = $resultado[0]['gru_cod'];
    $_SESSION ['grupo'] = $resultado[0]['gru_nombre'];
    $_SESSION ['id_sucursal'] = $resultado[0]['id_sucursal'];
        $_SESSION ['sucursal'] = $resultado[0]['suc_descri'];
        $_SESSION['usu_foto'] = 'img/avatar.jpg';
        header('location:menu.php');
}
