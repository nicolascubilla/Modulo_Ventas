<?php
require 'clases/conexion.php';

session_start(); // Iniciar la sesión

// Obtener y validar los parámetros
$accion = isset($_REQUEST['accion']) && is_numeric($_REQUEST['accion']) ? intval($_REQUEST['accion']) : 0;
$vid_factura = isset($_REQUEST['vid_factura']) && is_numeric($_REQUEST['vid_factura']) ? intval($_REQUEST['vid_factura']) : 0;
$vnro_cuota = isset($_REQUEST['vnro_cuota']) && is_numeric($_REQUEST['vnro_cuota']) ? intval($_REQUEST['vnro_cuota']) : 0;

// Ejecutar la función con los parámetros validados
if ($accion > 0 && $vid_factura > 0 && $vnro_cuota > 0) {
    $sql = "SELECT fn_cuentas_a_pagar_pagos($accion, $vid_factura, $vnro_cuota) AS resul";
    $resultado = consultas::get_datos($sql);

    if (!empty($resultado) && $resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = "Error al procesar el pago. Intente nuevamente.";
    }
} else {
    $_SESSION['mensaje'] = "Parámetros inválidos.";
}

// Redirigir con id_factura como parámetro en la URL
header("location: cuentas_a_pagar_compras.php?id_factura=" . $vid_factura);
exit;
