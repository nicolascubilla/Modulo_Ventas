<?php
require 'clases/conexion.php';
session_start();

try {
    function format_array($array) {
        return $array ? "'{" . implode(',', array_map('intval', $array)) . "}'" : 'NULL';
    }

    $accion        = intval($_POST['accion'] ?? 0);
    $vdescripcion  = pg_escape_string($_POST['vdescripcion'] ?? '');
    $vfecha_ajuste = !empty($_POST['vfecha_ajuste']) ? "'" . $_POST['vfecha_ajuste'] . "'" : 'NULL';
   

    $vusu_cod     = intval($_SESSION['usu_cod'] ?? 0);
    $vid_sucursal = intval($_SESSION['id_sucursal'] ?? 0);

    // Array de materiales y cantidades ajustadas
     $vdep_cod      = intval($_POST['vdep_cod'] ?? 0);
  // Tomar materiales tal cual
$materiales = $_POST['materiales'] ?? [];

// Tomar cantidades alineadas con los materiales
$cantidades = [];
foreach ($materiales as $mat) {
    $cantidades[] = intval($_POST['encontrada'][$mat] ?? 0);
}

// Formatear para enviarlos al function
$materiales = format_array($materiales);
$cantidades = format_array($cantidades);

    $vdep_cod = intval($_POST['vdep_cod'] ?? 0);

    $sql = "SELECT public.fn_ajuste_compras(
        $accion,
        '$vdescripcion',
        $vfecha_ajuste,
        $vusu_cod,
        $vid_sucursal,
        $materiales,
        $cantidades,
        $vdep_cod
    ) AS resul";



    $resultado = consultas::get_datos($sql);

    if ($resultado && isset($resultado[0]['resul'])) {
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("location:ajuste_compra_index.php" . (!empty($valor[1]) ? "?id=" . $valor[1] : ""));
        exit;
    } else {
        $_SESSION['mensaje'] = "Error al procesar la solicitud.";
        header("location:ajuste_compra_index.php");
        exit;
    }
} catch (Exception $e) {
    error_log("Error en ajuste compras: " . $e->getMessage());
    $_SESSION['mensaje'] = "Error al procesar: " . $e->getMessage();
    header("location:ajuste_compras_index.php");
    exit;
}
?>
