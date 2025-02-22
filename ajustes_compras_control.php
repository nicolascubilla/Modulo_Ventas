<?php
require 'clases/conexion.php'; // Incluye la conexión
session_start(); // Inicia o reanuda la sesión

try {
    // Función para convertir arrays a formato PostgreSQL
    function format_array($array) {
        return $array ? "'{" . implode(',', array_map('intval', $array)) . "}'" : 'NULL';
    }

    // Sanitización de datos
    $accion = intval($_POST['accion'] ?? 0);
    $vid_concepto = intval($_POST['vid_concepto'] ?? 0);
    $vid_factura = intval($_POST['vid_factura'] ?? 0);
    $vdescripcion = $_POST['vdescripcion'] ?? '';
    $vfecha_ajuste = !empty($_POST['vfecha_ajuste']) ? "'" . $_POST['vfecha_ajuste'] . "'" : 'NULL';
    $vusu_cod = intval($_POST['vusu_cod'] ?? 0);

    // Procesar arrays
    $materiales = format_array($_POST['vmaterial_id'] ?? []);
    $cantidades = format_array($_POST['cantidad_ajustada'] ?? []);

    // Preparar consulta
    $sql = "SELECT public.fn_ajuste_compras(
        $accion,
        $vid_concepto,
        $vid_factura,
        '$vdescripcion',
        $vfecha_ajuste,
        $vusu_cod,
        $materiales,
        $cantidades
    ) AS resul";

    // Ejecutar consulta
    $resultado = consultas::get_datos($sql);

    // Manejar resultado
    if (!empty($resultado) && $resultado[0]['resul'] !== null) {
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("location:ajuste_compra_index.php" . $valor[1]);
    } else {
        $_SESSION['mensaje'] = "Error al procesar la solicitud.";
        header("location:ajuste_compra_index.php");
    }
} catch (Exception $e) {
    // Manejo de errores
    error_log("Error en ajuste compras: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al procesar: " . $e->getMessage();
    header("location:ajuste_compra_index.php");
}
?>
