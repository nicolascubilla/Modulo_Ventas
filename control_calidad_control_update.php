
<?php
require 'clases/conexion.php';
session_start();

if (empty($_POST)) {
    die("Error: No se recibieron datos del formulario.");
}

// 1. Parámetros principales
$accion = isset($_POST['accion']) ? intval($_POST['accion']) : 2; // Asume acción 2 como default
$vcalidad_id = isset($_POST['vcalidad_id']) && $_POST['vcalidad_id'] !== '' ? intval($_POST['vcalidad_id']) : 'NULL';
$vid_resultado = isset($_POST['vid_resultado']) && $_POST['vid_resultado'] !== '' ? intval($_POST['vid_resultado']) : 'NULL';
$vobservaciones = isset($_POST['vobservaciones']) ? "'" . pg_escape_string($_POST['vobservaciones']) . "'" : "'Sin observaciones'";

// 2. Booleano para aprobado
$vaprobado = isset($_POST['vaprobado']) ? 'TRUE' : 'FALSE';


// 3. Arrays del detalle
$vart_cod = isset($_POST['vart_cod']) ? $_POST['vart_cod'] : [];
$vid_etapa = isset($_POST['vid_etapa']) ? $_POST['vid_etapa'] : [];
$vid_estado = isset($_POST['vid_estado']) ? $_POST['vid_estado'] : [];

// Validar que los arrays tienen igual longitud
if (count($vart_cod) !== count($vid_etapa) || count($vart_cod) !== count($vid_estado)) {
    $_SESSION['mensaje'] = "Error: los datos del detalle no son consistentes.";
    header("location:control_calidad_index.php");
    exit;
}

// Convertir arrays a formato SQL
$vart_cod_sql = !empty($vart_cod) ? "ARRAY[" . implode(',', array_map('intval', $vart_cod)) . "]" : "ARRAY[]::integer[]";
$vid_etapa_sql = !empty($vid_etapa) ? "ARRAY[" . implode(',', array_map('intval', $vid_etapa)) . "]" : "ARRAY[]::integer[]";
$vid_estado_sql = !empty($vid_estado) ? "ARRAY[" . implode(',', array_map('intval', $vid_estado)) . "]" : "ARRAY[]::integer[]";

// 4. Validación general
if ($vcalidad_id !== 'NULL' && $vid_resultado !== 'NULL') {
    $sql = "SELECT fn_control_calidad_update(
        $accion,
        $vcalidad_id,
        $vid_resultado,
        $vobservaciones,
        $vaprobado,
        $vart_cod_sql,
        $vid_etapa_sql,
        $vid_estado_sql
    ) AS resul;";

    $resultado = consultas::get_datos($sql);

    if ($resultado && isset($resultado[0]['resul'])) {
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("location:control_calidad_index.php" . (isset($valor[1]) ? $valor[1] : ""));
        exit;
    } else {
        error_log("Error en fn_control_calidad_update: " . $sql);
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
