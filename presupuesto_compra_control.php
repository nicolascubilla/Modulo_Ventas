<?php
require 'clases/conexion.php'; // Incluye la conexión

session_start(); // Inicia o reanuda la sesión

try {
    // Verificamos si se envió el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener los datos enviados desde el formulario
        $accion = isset($_POST['accion']) ? (int) $_POST['accion'] : 0;
        $vfecha_presu = pg_escape_string($_POST['vfecha_presu'] ?? null);
        $vid_pedido = (int) ($_POST['vid_pedido'] ?? 0);
        $vusu_cod = (int) ($_POST['vusu_cod'] ?? 0);
        $vprv_cod = (int) ($_POST['vprv_cod'] ?? 0);
        $vid_sucursal = (int) ($_POST['vid_sucursal'] ?? 0);

        // Detalle del pedido (arrays)
        $vcantidad_material = $_POST['cantidad_material'] ?? [];
        $vcosto_unitario = $_POST['costo_unitario'] ?? [];
        $vmaterial_id = $_POST['material_id'] ?? [];

          // Limpieza de datos
          $vcosto_unitario = array_map(function ($vcosto_unitario) {
            return (int) str_replace(['.', ','], '', $vcosto_unitario);
        }, $vcosto_unitario);

        // Validar datos requeridos
        if (empty($vfecha_presu) || empty($vid_pedido) || empty($vusu_cod) || empty($vprv_cod) || empty($vid_sucursal)) {
            throw new Exception("Faltan datos obligatorios para procesar el presupuesto.");
        }

        // Validar que los arrays no estén vacíos
        if (empty($vmaterial_id) || empty($vcantidad_material) || empty($vcosto_unitario)) {
            throw new Exception("El detalle del pedido no puede estar vacío.");
        }

        // Validar que los arrays tienen la misma longitud
        if (count($vmaterial_id) !== count($vcantidad_material) || count($vcantidad_material) !== count($vcosto_unitario)) {
            throw new Exception("Los arrays de detalle no tienen la misma longitud.");
        }

        // Construir los arrays en formato PostgreSQL
        $vcantidad_material_text = '{' . implode(',', array_map('intval', $vcantidad_material)) . '}';
        $vcosto_unitario_text = '{' . implode(',', array_map('intval', $vcosto_unitario)) . '}';
        $vmaterial_id_text = '{' . implode(',', array_map('intval', $vmaterial_id)) . '}';

        // Llamada a la función SQL
        $query = "SELECT public.fn_presupuesto_compras(
            $accion,
            '$vfecha_presu'::timestamp,
            $vid_pedido::integer,
            $vusu_cod::integer,
            $vprv_cod::integer,
            $vid_sucursal::integer,
            '$vcantidad_material_text'::integer[],
            '$vcosto_unitario_text'::integer[],
            '$vmaterial_id_text'::integer[]
        ) AS resul";

        $resultado =  consultas::get_datos($query); // Ejecución de la consulta (asegúrate de que $resultado sea un array)
        if($resultado[0]['resul']!=null){
            $valor = explode("*", $resultado[0]['resul']);
            $_SESSION['mensaje'] = $valor[0];
            header("location:presupuesto_compra_index.php".$valor[1]);
        } else {
            $_SESSION['mensaje'] = "Error al procesar\n$query";
            header("Location: presupuesto_compra_index.php");
            exit;
        }
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("Location: presupuesto_compra_index.php");
    exit;
}
?>
