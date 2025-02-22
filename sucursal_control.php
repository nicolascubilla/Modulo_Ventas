<?php
require 'clases/conexion.php';
session_start();

/*switch ($_REQUEST['accion']) {
    case 1:
        $sql = "insert into sucursal(id_sucursal, suc_descri) ".
        " values((select coalesce(max(id_sucursal),0)+1 from sucursal),upper(trim('".$_REQUEST['vsuc_descri']."')))";
        $mensaje = "Se inserto correctamente la sucursal";
        break;

    case 2:
        $sql = "update sucursal set suc_descri = upper(trim('".$_REQUEST['vsuc_descri']."')) where id_sucursal = ".
            $_REQUEST['vid_sucursal'];
        $mensaje = "Se actualizo correctamente la sucursal";
        break;
    
    case 3:
        $sql = "delete from sucursal where id_sucursal = ".$_REQUEST['vid_sucursal'];
        $mensaje = "Se borro correctamente la sucursal";
        break;
}
*/

$sql = "select sp_sucursal(".$_REQUEST['accion'].",".$_REQUEST['vid_sucursal'].",'".$_REQUEST['vsuc_descri']."') as resul";

$resultado = consultas::get_datos($sql);

if($resultado[0]['resul']!=null){
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:sucursal_index.php");
}else{
    $_SESSION['mensaje'] = "Error al procesar \n".$sql;
    echo $sql;
}