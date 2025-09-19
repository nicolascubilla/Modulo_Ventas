<?php
require 'clases/conexion.php';
session_start();

$accion = isset($_REQUEST['accion']) ? intval($_REQUEST['accion']) : 0;
$vid_factura = isset($_REQUEST['vid_factura']) ? intval($_REQUEST['vid_factura']) : 0;
$vnro_cuota = isset($_REQUEST['vnro_cuota']) ? intval($_REQUEST['vnro_cuota']) : 0;
$vid_metodo_pago = isset($_REQUEST['id_metodo_pago']) ? intval($_REQUEST['id_metodo_pago']) : null;

if ($accion > 0 && $vid_factura > 0 && $vnro_cuota > 0 && $vid_metodo_pago > 0) {
    $sql = "SELECT fn_cuentas_a_pagar_pagos($accion, $vid_factura, $vnro_cuota, $vid_metodo_pago) AS resul";
    $resultado = consultas::get_datos($sql);

    if (!empty($resultado) && $resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = "Error al procesar el pago. Intente nuevamente.";
    }
} else {
    $_SESSION['mensaje'] = "Parámetros inválidos.";
}

header("location: cuentas_a_pagar_compras.php?id_factura=" . $vid_factura);
exit;
?>