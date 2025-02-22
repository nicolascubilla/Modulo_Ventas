<?php
require 'clases/conexion.php';
session_start();

try {
    // Verificar que los parámetros GET 'vpresupuesto_id' y 'accion' existen y son válidos
    if (!isset($_GET['vpresupuesto_id']) || !isset($_GET['accion'])) {
        throw new Exception("Parámetros inválidos para la solicitud.");
    }

    $vpresupuesto_id = (int)$_GET['vpresupuesto_id'];  // Convertir a entero
    $accion = (int)$_GET['accion'];

    // Validar parámetros
    if ($vpresupuesto_id <= 0) {
        throw new Exception("ID de presupuesto inválido.");
    }
    if ($accion !== 2) {
        throw new Exception("Acción inválida.");
    }

    // Construir el SQL para llamar al procedimiento almacenado
    $sql = "SELECT sp_ordcompra_anular(
        $accion,               -- Acción de anulación
        $vpresupuesto_id      -- ID del presupuesto
        
    ) AS resul";

    // Ejecutar la consulta y obtener el resultado
    $resultado = consultas::get_datos($sql);

    if ($resultado && isset($resultado[0]['resul'])) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];  // Mensaje del procedimiento
    } else {
        throw new Exception("Error al procesar la anulación del presupuesto.");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = $e->getMessage();  // Capturar el mensaje de error
} finally {
    header("Location: ordcompra_index.php");
    exit;
}
