<?php
require 'clases/conexion.php'; // Incluye la conexión
session_start(); // Inicia o reanuda la sesión

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validar y capturar las entradas
        $accion = isset($_POST['accion']) ? (int) $_POST['accion'] : 0;
        $vfecha = $_POST['vfecha'] ?? null;
        $vpre_cod = (int) ($_POST['vpre_cod'] ?? 0);
        $vequipo_id = (int) ($_POST['vequipo_id'] ?? 0);
        $vid_sucursal = (int) ($_POST['vid_sucursal'] ?? 0);
        $vusu_cod = (int) ($_POST['vusu_cod'] ?? 0);

        // Detalle del pedido (arrays)
        $vart_cod = $_POST['vart_cod'] ?? [];
        $vord_cant = $_POST['vord_cant'] ?? [];

        // Validaciones básicas
        if (empty($vfecha) || $vpre_cod <= 0 || $vequipo_id <= 0 || $vid_sucursal <= 0 || $vusu_cod <= 0) {
            throw new Exception("Datos obligatorios faltantes o inválidos.");
        }

        if (empty($vart_cod) || empty($vord_cant)) {
            throw new Exception("Los detalles de artículos y cantidades no pueden estar vacíos.");
        }

        if (count($vart_cod) !== count($vord_cant)) {
            throw new Exception("Los arrays de artículos y cantidades deben tener la misma longitud.");
        }

        // Convertir los arrays a formato PostgreSQL
        $vart_cod_pgsql = '{' . implode(',', array_map('intval', $vart_cod)) . '}';
        $vord_cant_pgsql = '{' . implode(',', array_map('intval', $vord_cant)) . '}';

        // Llamada a la función SQL
        $query = "SELECT public.fn_orden_produccion(
            $accion,
            $vpre_cod::integer,
            $vequipo_id::integer,
            $vid_sucursal::integer,
            $vusu_cod::integer,
            '$vfecha'::timestamp,
            '$vart_cod_pgsql'::integer[],
            '$vord_cant_pgsql'::integer[]
        ) AS resul";

        // Ejecución de la consulta
        $resultado = consultas::get_datos($query);

        if ($resultado && isset($resultado[0]['resul']) && $resultado[0]['resul'] !== null) {
            $valor = explode("*", $resultado[0]['resul']);
            $_SESSION['mensaje'] = $valor[0];

            // Redirección según el resultado
            $redirect = isset($valor[1]) ? "orden_produccion_index.php" . $valor[1] : "orden_produccion_index.php";
            header("Location: $redirect");
        } else {
            throw new Exception("Error al procesar la consulta SQL:\n$query");
        }
    } else {
        throw new Exception("Método de solicitud no válido.");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("Location: orden_produccion_index.php");
    exit;
}
