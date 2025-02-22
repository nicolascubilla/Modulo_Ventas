<?php
require 'clases/conexion.php';
session_start();

if (empty($_POST)) {
    die("Error: No se recibieron datos del formulario.");
}

// Sanitización básica (mejor usar consultas preparadas)
$accion = isset($_POST['accion']) ? $_POST['accion'] : 'NULL';
$vcontrol_id = isset($_POST['vcontrol_id']) ? intval($_POST['vcontrol_id']) : 'NULL';
$vfecha_inspeccion = isset($_POST['vfecha_inspeccion']) ? "'" . pg_escape_string($_POST['vfecha_inspeccion']) . "'" : 'NULL';
$vid_resultado = isset($_POST['vid_resultado']) ? intval($_POST['vid_resultado']) : 'NULL';
$vobservacion = isset($_POST['vobservacion']) ? "'" . pg_escape_string($_POST['vobservacion']) . "'" : 'NULL';
$vaprobado = isset($_POST['vaprobado']) ? "'".$_POST['vaprobado']."'" : "'N'";
$vresponsable_inspeccion = isset($_POST['vresponsable_inspeccion']) ? intval($_POST['vresponsable_inspeccion']) : 'NULL';

// Validación y conversión de arrays
$vart_cod = isset($_POST['vart_cod']) ? $_POST['vart_cod'] : [];
$vcantidad = isset($_POST['vcantidad']) ? $_POST['vcantidad'] : [];
$id_estado = isset($_POST['id_estado']) ? $_POST['id_estado'] : [];
$vcantidad_rechazada = isset($_POST['vcantidad_rechazada']) ? $_POST['vcantidad_rechazada'] : [];
$vcantidad_critica = isset($_POST['vcantidad_critica']) ? $_POST['vcantidad_critica'] : [];

$vart_cod = !empty($vart_cod) ? "ARRAY[" . implode(',', array_map('intval', $vart_cod)) . "]" : "NULL";
$vcantidad = !empty($vcantidad) ? "ARRAY[" . implode(',', array_map('intval', $vcantidad)) . "]" : "NULL";
$id_estado = !empty($id_estado) ? "ARRAY[" . implode(',', array_map('intval', $id_estado)) . "]" : "NULL";
$vcantidad_rechazada = !empty($vcantidad_rechazada) ? "ARRAY[" . implode(',', array_map('intval', $vcantidad_rechazada)) . "]" : "NULL";
$vcantidad_critica = !empty($vcantidad_critica) ? "ARRAY[" . implode(',', array_map('intval', $vcantidad_critica)) . "]" : "NULL";

// Validación antes de ejecutar la consulta
if ($vcontrol_id !== 'NULL' && $vfecha_inspeccion !== 'NULL' && $vid_resultado !== 'NULL' && $vresponsable_inspeccion !== 'NULL') {
    $sql = "SELECT fn_control_calidad(
              $accion, $vcontrol_id, $vfecha_inspeccion, $vid_resultado, $vobservacion, 
              $vaprobado, $vresponsable_inspeccion, 
              $vart_cod, $vcantidad, $id_estado, $vcantidad_rechazada, $vcantidad_critica
            ) as resul";

    $resultado = consultas::get_datos($sql);

    if ($resultado && isset($resultado[0]['resul'])) {
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("location:control_calidad_index.php" . $valor[1]);
        exit;
    } else {
        error_log("Error en fn_control_calidad: " . $sql);
        $_SESSION['mensaje'] = "Error al procesar la solicitud. Contacte con soporte.";
        header("location:control_calidad_index.php");
        exit;
    }
} else {
    $_SESSION['mensaje'] = "Datos incompletos. Por favor, complete todos los campos requeridos.";
    header("location:control_calidad_index.php");
    exit;
}
?>
