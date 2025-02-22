<?php
require 'clases/conexion.php';
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar y capturar las entradas
        $accion = (int) ($_POST['accion'] ?? 0);
        $vord_cod = (int) ($_POST['vord_cod'] ?? 0);
        $vequipo_id = (int) ($_POST['vequipo_id'] ?? 0);
        $vfecha = $_POST['vfecha'] ?? null;
        $vsucursal = (int) ($_POST['vsucursal'] ?? 0);
        $vusuario = (int) ($_POST['vusuario'] ?? 0);
    
        $vmaterial_id = $_POST['vmaterial_id'] ?? [];
        $vcantidad = $_POST['vcantidad'] ?? [];
        $vdep_cod = (int) ($_POST['vdep_cod'] ?? 0);

        // Validaciones
        if (!$vfecha || !DateTime::createFromFormat('Y-m-d H:i:s.uP', $vfecha)) {
            throw new Exception("La fecha no es válida o está vacía.");
        }
        

        if ($vord_cod <= 0 || $vequipo_id <= 0 || $vsucursal <= 0 || $vusuario <= 0 ) {
            throw new Exception("Datos obligatorios faltantes o inválidos.");
        }

        if (empty($vmaterial_id) || empty($vcantidad) || count($vmaterial_id) !== count($vcantidad)) {
            throw new Exception("Los detalles de materiales y cantidades son inválidos.");
        }

        // Convertir los arrays a formato PostgreSQL
        $vmaterial_id_pgsql = '{' . implode(',', array_map('intval', $vmaterial_id)) . '}';
        $vcantidad_pgsql = '{' . implode(',', array_map('intval', $vcantidad)) . '}';

        // Construcción y ejecución de la consulta
        $query = "SELECT public.fn_pedidos_materia_prima(
            $accion,
            $vord_cod::integer,
            $vequipo_id::integer,
            '$vfecha'::timestamp,
            $vsucursal::integer,
            $vusuario::integer,
            '$vmaterial_id_pgsql'::integer[],
            '$vcantidad_pgsql'::integer[],
             $vdep_cod::integer
        ) AS resul";

        $resultado = consultas::get_datos($query);

        if ($resultado && isset($resultado[0]['resul'])) {
            $valor = explode("*", $resultado[0]['resul']);
            $_SESSION['mensaje'] = $valor[0];
            $redirect = isset($valor[1]) ? "pedidos_materia_prima_index.php" . $valor[1] : "pedidos_materia_prima_index.php";
            header("Location: $redirect");
            exit;
        } else {
            throw new Exception("Error al procesar la consulta SQL.");
        }
    } else {
        throw new Exception("Método de solicitud no válido.");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("Location: pedidos_materia_prima_index.php");
    exit;
}
