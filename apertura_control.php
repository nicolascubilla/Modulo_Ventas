<?php
require 'clases/conexion.php';
session_start();

// Obtener y preparar los valores
$accion = $_REQUEST['accion'];
$vid_caja = !empty($_REQUEST['vid_caja']) ? $_REQUEST['vid_caja'] : "NULL";
$vfecha = !empty($_REQUEST['vfecha_formateada']) ? $_REQUEST['vfecha_formateada'] : null;
$vhora_apertura = !empty($_REQUEST['vhora_apertura']) ? $_REQUEST['vhora_apertura'] : null;
$vmonto_apertura = !empty($_REQUEST['vmonto_apertura']) ? $_REQUEST['vmonto_apertura'] : "NULL";
$vhora_cierre = !empty($_REQUEST['vhora_cierre']) ? $_REQUEST['vhora_cierre'] : null;
$vmonto_cierre = !empty($_REQUEST['vmonto_cierre']) ? $_REQUEST['vmonto_cierre'] : "NULL";
$vobservaciones = !empty($_REQUEST['vobservaciones']) ? "'{$_REQUEST['vobservaciones']}'" : "NULL";
$vid_usuario_apertura = !empty($_REQUEST['vid_usuario_apertura']) ? $_REQUEST['vid_usuario_apertura'] : "NULL";
$vid_usuario_cierre = !empty($_REQUEST['vusuario_cierre']) ? $_REQUEST['vusuario_cierre'] : "NULL";
$vid_estado = !empty($_REQUEST['vestado']) ? "'{$_REQUEST['vestado']}'" : "NULL";
$vid_sucursal = isset($_SESSION['id_sucursal']) ? $_SESSION['id_sucursal'] : "NULL";
// Armar timestamps si fecha y hora existen
$timestamp_apertura = ($vfecha && $vhora_apertura) ? "'{$vfecha} {$vhora_apertura}:00'" : "NULL";
$timestamp_cierre = ($vfecha && $vhora_cierre) ? "'{$vfecha} {$vhora_cierre}:00'" : "NULL";

// Armar la consulta SQL
$sql = "SELECT fn_apertura_cierre_caja(
    {$accion},
    {$vid_caja},
    " . ($vfecha ? "'{$vfecha}'" : "NULL") . ",
    {$timestamp_apertura},
    {$vmonto_apertura},
    {$timestamp_cierre},
    {$vmonto_cierre},
    {$vobservaciones},
    {$vid_usuario_apertura},
    {$vid_usuario_cierre},
    {$vid_estado},
    {$vid_sucursal}
) AS resul;";

// Ejecutar consulta
$resultado = consultas::get_datos($sql);

// Procesar resultado
if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']); // formato: "Mensaje*redireccion.php"
    $_SESSION['mensaje'] = $valor[0];
    header("Location: apertura_caja_index.php" . $valor[1]);
} else {
    $_SESSION['mensaje'] = "Error al procesar: " . $sql;
    header("Location: apertura_caja_index.php");
}
?>