<?php
require 'clases/conexion.php'; // Incluye la conexión
session_start(); // Inicia o reanuda la sesión

try {
    // Validar y sanitizar datos
    $accion = isset($_POST['accion']) ? intval($_POST['accion']) : 0;
    $vid_factura = isset($_POST['vid_factura']) ? intval($_POST['vid_factura']) : 0;
    $vfecha_nota = isset($_POST['vfecha_nota']) ? date('Y-m-d H:i:s', strtotime($_POST['vfecha_nota'])) : null;
    $vmonto_nota = isset($_POST['vmonto_nota']) 
    ? floatval(str_replace(',', '', $_POST['vmonto_nota'])) 
    : 0.0;

    $vmotivo = isset($_POST['vmotivo']) ? "'" . pg_escape_string($_POST['vmotivo']) . "'" : 'NULL';
    $vid_sucursal = isset($_POST['vid_sucursal']) ? intval($_POST['vid_sucursal']) : 0;
    $vusu_cod = isset($_POST['vusu_cod']) ? intval($_POST['vusu_cod']) : 0;

    // Construir la consulta SQL
    $sql = sprintf(
        "SELECT public.fn_nota_credito(%d, %d, '%s', %d, %s, %d, %d) AS resul",
        $accion,
        $vid_factura,
        $vfecha_nota,
        $vmonto_nota,
        $vmotivo,
        $vid_sucursal,
        $vusu_cod
    );


    // Ejecutar la consulta
    $resultado = consultas::get_datos($sql);

    // Procesar resultado
    if ($resultado && isset($resultado[0]['resul']) && $resultado[0]['resul'] != null) {
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("location:nota_credito_compras_index.php" . $valor[1]);
    } else {
        $_SESSION['mensaje'] = "Error al procesar la consulta: " . $sql;
        header("location:nota_credito_compras_index.php");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error al procesar: " . $e->getMessage();
    header("location:nota_credito_compras_index.php");
}
