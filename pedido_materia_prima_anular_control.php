<?php
require 'clases/conexion.php';
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $accion = isset($_POST['accion']) ? (int) $_POST['accion'] : 0;
        $vord_cod = isset($_POST['vord_cod']) ? (int) $_POST['vord_cod'] : 0;

        if ($accion == 2) { // Anulación de la orden
            if ($vord_cod <= 0) {
                throw new Exception("Código de pedido inválido.");
            }

            // Llamar a la función SQL solo con los datos necesarios
            $query = "SELECT public.fn_pedidos_materia_prima(
                $accion,
                $vord_cod::integer,
                NULL, NULL, NULL, NULL, NULL, NULL, NULL
            ) AS resul";

            $resultado = consultas::get_datos($query);

            if ($resultado && isset($resultado[0]['resul']) && $resultado[0]['resul'] !== null) {
                $_SESSION['mensaje'] = $resultado[0]['resul'];
                header("Location: pedidos_materia_prima_index.php");
                exit;
            } else {
                throw new Exception("Error al procesar la consulta.");
            }
        }

        // Manejo de otras acciones aquí...
        // (Si acción no es 2, sigue el flujo normal del controlador)

    } else {
        throw new Exception("Método de solicitud no válido.");
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("Location: pedidos_materia_prima_index.php");
    exit;
}
