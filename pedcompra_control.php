<?php
require 'clases/conexion.php';
session_start();

// Verificar que los parámetros GET 'vid_pedido' y 'accion' existen y son válidos
if (isset($_GET['vid_pedido']) && isset($_GET['accion'])) {
    $vid_pedido = (int)$_GET['vid_pedido'];  // Convertir a entero para mayor seguridad
    $accion = (int)$_GET['accion'];

    // Validar que la acción sea de anulación (accion = 2)
    if ($accion === 2) {
        // Construir el SQL para llamar al procedimiento almacenado con la acción de anulación
        $sql = "SELECT fn_pedido_compras_editar(
            $accion,     -- Acción de anulación
            NULL,        -- No se requiere fecha
            NULL,        -- No se requiere observación
            NULL,        -- No se requiere usuario
            NULL,        -- No se requiere sucursal
            NULL,        -- No se requiere materiales
            NULL,        -- No se requiere cantidades
            $vid_pedido  -- ID del pedido que queremos anular
        ) AS resul";

        // Ejecutar la consulta y obtener el resultado
        $resultado = consultas::get_datos($sql);

        // Verificar si la anulación fue exitosa
        if ($resultado && isset($resultado[0]['resul'])) {
            $_SESSION['mensaje'] = $resultado[0]['resul'];  // Mensaje del procedimiento
            header("Location: pedcompra_index.php");  // Redirigir al índice de pedidos
            exit;
        } else {
            $_SESSION['mensaje'] = "Error al procesar la anulación del pedido.";
            header("Location: pedcompra_index.php");
            exit;
        }
    } else {
        // Si la acción no es de anulación, mostrar mensaje de error
        $_SESSION['mensaje'] = "Acción inválida.";
        header("Location: pedcompra_index.php");
        exit;
    }
} else {
    // Si faltan parámetros, mostrar mensaje de error
    $_SESSION['mensaje'] = "Parámetros inválidos para la solicitud.";
    header("Location: pedcompra_index.php");
    exit;
}
