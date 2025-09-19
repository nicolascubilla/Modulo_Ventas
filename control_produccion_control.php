<?php
require 'clases/conexion.php';
session_start(); // Inicia o reanuda la sesión actual

try {
    // Recibe los datos enviados por POST
    $accion = $_POST['accion'];
    $vpedido_id = $_POST['vpedido_id'];
    $vfecha_avance = $_POST['vfecha_avance'];
    $vprogreso = $_POST['vprogreso'];
    $vtiempo_invertido = $_POST['vtiempo_invertido'];
    $vcomentario = $_POST['vcomentario'];
    $vid_sucursal = $_POST['vid_sucursal'];
    $vusu_cod = $_POST['vusu_cod'];
    $vart_cod = $_POST['vart_cod']; // Arreglo de artículos
    $vcantidad = $_POST['vcantidad']; // Arreglo de cantidades
    $vestado_etapa = $_POST['vestado_etapa']; // Arreglo de etapas (clave: id_etapa, valor: estado)

    // Validar que los datos necesarios están presentes
    if (
        empty($accion) || empty($vpedido_id) || empty($vfecha_avance) ||
        empty($vtiempo_invertido) || 
        empty($vid_sucursal) || empty($vusu_cod) || empty($vart_cod) ||
        empty($vcantidad) || empty($vestado_etapa)
    ) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    // Transformar $vestado_etapa en arreglos separados de id_etapa y estado_etapa
    $vid_etapa = array_keys($vestado_etapa); // Extrae las claves como id_etapa
    $vestado_etapa = array_values($vestado_etapa); // Extrae los valores como estado_etapa

    // Construir la consulta SQL para llamar a la función
    $sql = "SELECT fn_control_produccion(
        $accion, $vpedido_id, '$vfecha_avance', '$vprogreso', $vtiempo_invertido, 
        '$vcomentario', $vid_sucursal, $vusu_cod, 
        ARRAY[" . implode(',', $vart_cod) . "], 
        ARRAY[" . implode(',', $vcantidad) . "], 
        ARRAY[" . implode(',', $vid_etapa) . "], 
        ARRAY[" . implode(',', $vestado_etapa) . "]
    ) AS mensaje";

    // Ejecutar la consulta
    $resultado = consultas::get_datos($sql);

    // Procesar resultado
    if ($resultado && isset($resultado[0]['mensaje'])) {
        $valor = explode("*", $resultado[0]['mensaje']); // Separar mensaje y datos adicionales
        $_SESSION['mensaje'] = $valor[0]; // Guardar el mensaje en la sesión
        header("Location: control_produccion_index.php" . (isset($valor[1]) ? $valor[1] : ""));
        exit;
    } else {
        throw new Exception("Error al procesar la consulta: " . $sql);
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("Location: control_produccion_index.php");
    exit;
}
?>
