<?php
require 'clases/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos principales
    $accion = $_POST['accion'];
    $fecha_pedido = $_POST['vfecha_pedido'];
    $observacion = $_POST['vobservacion'];
    $usu_cod = $_POST['vusu_cod'];
    
    $id_sucursal = $_POST['vid_sucursal'];

    // Recoger detalles como arreglos
    $material_ids = $_POST['material_id'] ?? [];
    $cantidades = $_POST['cantidad'] ?? [];

    // Validar que existan detalles
    if (empty($material_ids) || empty($cantidades)) {
        $_SESSION['mensaje'] = "Debe agregar al menos un detalle.";
        header('Location: pedcompra_index.php');
        exit;
    }

    // Construir el SQL para llamar al procedimiento almacenado
    $sql = "SELECT fn_pedido_compras(
        $accion,
        '$fecha_pedido',
        '$observacion',
        $usu_cod,
        $id_sucursal,
        ARRAY[" . implode(',', $material_ids) . "]::integer[],
        ARRAY[" . implode(',', $cantidades) . "]::integer[]
    ) AS resul";

    // Log temporal para verificar la consulta generada
    error_log("SQL Generado: $sql");

      
    $resultado = consultas::get_datos($sql);

    // Comprobar el resultado de la función
    if ($resultado[0]['resul'] != null) {
        // Separar el resultado del mensaje
        $valor = explode("*", $resultado[0]['resul']);
        $_SESSION['mensaje'] = $valor[0];  // Mensaje de éxito o error
        header("Location: pedcompra_index.php" . $valor[1]);  // Redirigir con el mensaje
    } else {
        $_SESSION['mensaje'] = "Error al procesar la solicitud: " . $sql; // Mensaje de error
        header("Location: pedcompra_index.php");
    }
}
?>