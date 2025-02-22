<?php
require 'clases/conexion.php'; // Asegúrate de tener esta función de base de datos
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos principales
    $accion = $_POST['accion']; // Acción (1: Crear, 2: Anular, 3: Editar)
    $id_pedido = $_POST['vid_pedido'];
    $fecha_pedido = $_POST['vfecha_pedido'];
    $usu_cod = $_POST['vusu_cod'];
    $observacion = $_POST['vobservacion'];
    $id_sucursal = $_POST['vid_sucursal'];

    // Recoger detalles como arreglos
    $material_ids = $_POST['material_id'] ?? [];  // Array de IDs de materiales
    $cantidades = $_POST['cantidad'] ?? [];       // Array de cantidades

    // Validar que existan detalles
    if (isset($_POST['material_ids']) && isset($_POST['cantidades'])) {
        $material_ids = $_POST['material_ids'];
        $cantidades = $_POST['cantidades'];
    
        if (count($material_ids) > 0) {
            // Proceder con el procesamiento de los detalles
        } else {
            $_SESSION['mensaje'] = "Debe agregar al menos un detalle.";
            // Redirigir o mostrar el mensaje de error
        }
    } else {
        $_SESSION['mensaje'] = "No se recibieron los detalles correctamente.";
        // Redirigir o mostrar el mensaje de error
    }
    
    // Construir el SQL para llamar al procedimiento almacenado
    // Usamos el formato adecuado para pasar los arrays como parámetros de la función
    $sql = "SELECT fn_pedido_compras_editar(
        $accion,                    -- ban (1: crear, 2: anular, 3: editar)
        '$fecha_pedido'::TIMESTAMP,      -- vfecha_pedido
        '$observacion'::TEXT,       -- vobservacion
        $usu_cod,                   -- vusu_cod
        $id_sucursal,               -- vid_sucursal
        ARRAY[" . implode(',', $material_ids) . "]::integer[],  -- vmaterial_ids
        ARRAY[" . implode(',', $cantidades) . "]::integer[],   -- vcantidades
        $id_pedido                  -- vid_pedido
    ) AS resul";
    
    // Ejecutar la consulta para obtener el resultado
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
