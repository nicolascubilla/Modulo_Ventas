<?php
require 'clases/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_comprobante'])) {
    try {
        $tipo_id = intval($_POST['tipo_comprobante']);

        // 1. Obtener los datos del tipo de comprobante
      $sql_tipo = "SELECT * FROM tipos_comprobante WHERE id_tipo = ".$_POST['tipo_comprobante'];
        $tipo = consultas::get_datos($sql_tipo);

        if (!$tipo) {
            throw new Exception("Tipo de comprobante no encontrado.");
        }
        $tipo = $tipo[0]; // Tomamos la primera fila del resultado

        // 2. Buscar el último número emitido para este tipo
        $sql_ultimo = "
            SELECT MAX(nro_comprobante) AS ultimo
            FROM ventas
            WHERE id_tipo_comprobante = {$tipo_id}
        ";
        $ultimo = consultas::get_datos($sql_ultimo);
        $ultimo_numero = $ultimo[0]['ultimo'] ?? '';

        // 3. Extraer número y calcular el siguiente
        $numero = intval(preg_replace('/[^0-9]/', '', $ultimo_numero));
        $proximo_numero = $numero + 1;

        // 4. Formatear el nuevo comprobante
        if ($tipo['es_factura']) {
            // Ejemplo: A-00000001
            $nro_comprobante = $tipo['letra'] . '-' . str_pad($proximo_numero, 8, '0', STR_PAD_LEFT);
        } else {
            // Ejemplo: NC-000001
            $nro_comprobante = $tipo['codigo_interno'] . '-' . str_pad($proximo_numero, 6, '0', STR_PAD_LEFT);
        }

        echo $nro_comprobante;

    } catch (Exception $e) {
        http_response_code(500);
        echo "Error al generar número: " . $e->getMessage();
    }

} else {
    http_response_code(400);
    echo "Solicitud inválida";
}
?>