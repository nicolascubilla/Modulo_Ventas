<?php
require 'clases/conexion.php';

$ord_cod = $_POST['ord_cod']; 

if ($ord_cod) {
    $cabecera = consultas::get_datos("SELECT equipo_id, nombre_equipo FROM v_listar_orden_pendientes WHERE ord_cod = $ord_cod LIMIT 1");
    $detalles = consultas::get_datos("SELECT art_cod, art_descri, ord_cant FROM v_listar_orden_pendientes WHERE ord_cod = $ord_cod");

    if ($cabecera) {
        // Preparar la respuesta
        $response = [
            'vequipo_id' => $cabecera[0]['equipo_id'] ?? '', // Incluye el código del equipo
            'nombre_equipo' => $cabecera[0]['nombre_equipo'] ?? '', // Nombre del equipo
            'detalles' => $detalles // Detalles de los materiales
        ];
    } else {
        $response = [
            'vequipo_id' => '',
            'nombre_equipo' => '',
            'detalles' => []
        ];
    }
} else {
    $response = [
        'vequipo_id' => '',
        'nombre_equipo' => '',
        'detalles' => []
    ];
}

// Configurar el encabezado para JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
