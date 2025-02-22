<?php
require 'clases/conexion.php'; // Incluye la conexión
session_start(); // Inicia o reanuda la sesión

try {
    // Convertir los arrays enviados por POST en formato compatible con PostgreSQL
    $materiales = isset($_POST['material_id']) ? "'{" . implode(',', $_POST['material_id']) . "}'" : 'NULL';
    $cantidades = isset($_POST['cantidad_material']) ? "'{" . implode(',', $_POST['cantidad_material']) . "}'" : 'NULL';
    $costos = isset($_POST['costo_unitario']) ? "'{" . implode(',', $_POST['costo_unitario']) . "}'" : 'NULL';

    // Verificar si otros datos están presentes
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;
    $vpresupuesto_id = isset($_POST['vpresupuesto_id']) ? $_POST['vpresupuesto_id'] : 'NULL';
    $vfecha_orden = isset($_POST['vfecha_orden']) ? $_POST['vfecha_orden'] : 'NULL';
    $vprv_cod = isset($_POST['prv_cod']) ? $_POST['prv_cod'] : 'NULL';
    $vplazo_entrega = isset($_POST['vplazo_entrega']) ? $_POST['vplazo_entrega'] : 'NULL';
    $vusu_cod = isset($_POST['vusu_cod']) ? $_POST['vusu_cod'] : 'NULL';
    $vid_sucursal = isset($_POST['vid_sucursal']) ? $_POST['vid_sucursal'] : 'NULL';

    if ($accion === null) {
        throw new Exception("El parámetro 'accion' no fue enviado correctamente.");
    }

    // Construir la consulta SQL con los arrays formateados
    $sql = "SELECT public.sp_ordcompra(
        $accion::integer, 
        $vpresupuesto_id::integer,
        '$vfecha_orden'::timestamp,
        $vprv_cod::integer,
        '$vplazo_entrega'::date,
        $vusu_cod::integer,
        $vid_sucursal::integer,
        $materiales::integer[],
        $cantidades::integer[],
        $costos::integer[]
    ) AS resul";

    // Ejecutar la consulta
    $resultado = consultas::get_datos($sql);

    // Procesar el resultado
    if ($resultado[0]['resul'] != null) {
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];
        header("Location: ordcompra_index.php" . ($valor[1] ?? ''));
    } else {
        throw new Exception("Error al procesar la solicitud. SQL: " . $sql);
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error al procesar: " . $e->getMessage();
    header("location:ordcompra_index.php");
}
