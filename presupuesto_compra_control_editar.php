<?php
require 'clases/conexion.php'; // Incluye la conexión

session_start(); // Inicia o reanuda la sesión

try {
    // Verificamos si se envió el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener y limpiar datos enviados desde el formulario
        $accion = isset($_POST['accion']) ? (int) $_POST['accion'] : 0;
        $vfecha_presu = pg_escape_string($_POST['vfecha_presu'] ?? null);
        $vid_pedido = (int) ($_POST['vid_pedido'] ?? 0);
        $vusu_cod = (int) ($_POST['vusu_cod'] ?? 0);
        $vprv_cod = (int) ($_POST['vprv_cod'] ?? 0);
        $vid_sucursal = (int) ($_POST['vid_sucursal'] ?? 0);
        $vpresupuesto_id = (int) ($_POST['vpresupuesto_id'] ?? 0);
        $vcosto_unitario = $_POST['vcosto_unitario'] ?? [];
        $vmaterial_id = $_POST['vmaterial_id'] ?? [];
        $vcantidad_material = $_POST['vcantidad_material'] ?? [];

        // Limpieza de datos
        $vcosto_unitario = array_map(function ($costo) {
            return (int) str_replace(['.', ','], '', $costo);
        }, $vcosto_unitario);
        $vmaterial_id = array_map('intval', $vmaterial_id);
        $vcantidad_material = array_map('intval', $vcantidad_material);

        // Validaciones
        if ($accion === 2) { // Anular
            if (empty($vid_pedido)) {
                throw new Exception("El ID del pedido es obligatorio para anular.");
            }
        } elseif ($accion === 3) { // Editar
            if (empty($vfecha_presu) || empty($vid_pedido) || empty($vusu_cod) || empty($vprv_cod) || empty($vid_sucursal) || empty($vpresupuesto_id)) {
                throw new Exception("Datos obligatorios faltantes: fecha, pedido, usuario, proveedor, sucursal, presupuesto.");
            }
            if (empty($vcosto_unitario) || empty($vmaterial_id) || empty($vcantidad_material)) {
                throw new Exception("El detalle del pedido no puede estar vacío.");
            }
            if (count($vmaterial_id) !== count($vcantidad_material) || count($vcantidad_material) !== count($vcosto_unitario)) {
                throw new Exception("Los arrays de detalle no tienen la misma longitud.");
            }
        } else {
            throw new Exception("Acción no válida.");
        }

        // Construcción de la consulta
        $query = "SELECT public.fn_presupuesto_compras_editar(
            $accion,
            $vpresupuesto_id::integer,
            $vid_pedido::integer,
            " . ($vfecha_presu ? "'$vfecha_presu'::timestamp" : "NULL") . ",
            $vusu_cod::integer,
            $vprv_cod::integer,
            $vid_sucursal::integer,
            ARRAY[" . implode(',', $vcosto_unitario) . "]::integer[],
            ARRAY[" . implode(',', $vmaterial_id) . "]::integer[],
            ARRAY[" . implode(',', $vcantidad_material) . "]::integer[]
        ) AS resul";

        // Ejecución de la consulta
        $resultado = consultas::get_datos($query);

        // Validar el resultado y redirigir
        if ($resultado[0]['resul'] != null) {
            $valor = explode("*", $resultado[0]['resul']);
            $_SESSION['mensaje'] = $valor[0];
            header("Location: presupuesto_compra_index.php" . ($valor[1] ?? ''));
        } else {
            $_SESSION['mensaje'] = "Error al procesar la operación.\n$query";
            header("Location: presupuesto_compra_index.php");
            exit;
        }
    } else {
        throw new Exception("Método no permitido.");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("Location: presupuesto_compra_index.php");
    exit;
}
