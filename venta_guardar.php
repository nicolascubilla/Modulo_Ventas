<?php
require 'clases/conexion.php';
session_start();

try {
    $accion = $_POST['accion'] ?? 1;

    // Datos cabecera
    $control_id = $_POST['vcontrol_id'] ?? 'NULL';
    $cli_cod = $_POST['vcli_cod'] ?? 'NULL';
    $ven_fecha = $_POST['vven_fecha'] ?? date('Y-m-d H:i:s');
    $ven_fecha_venc = isset($_POST['vven_fecha_vencimiento']) && !empty($_POST['vven_fecha_vencimiento']) 
        ? str_replace('T', ' ', $_POST['vven_fecha_vencimiento']) . ":00"
        : date('Y-m-d H:i:s', strtotime('+30 days'));

    $tipo_comprobante = $_POST['vid_tipo_comprobante'] ?? 'NULL';
    $nro_comprobante = $_POST['vnro_comprobante'] ?? 'NULL';
    $condicion_pago = $_POST['vid_condicion_pago'] ?? $_POST['id_condicion_pago'] ?? 'NULL'; // Corrección para ambos nombres
    $observaciones = $_POST['vobservaciones'] ?? '';

    // Validación de datos básicos
    if (empty($_POST['detalle']) || !is_array($_POST['detalle'])) {
        $_SESSION['mensaje'] = "Error: No hay artículos en la venta";
        header("location: ventas_index.php");
        exit;
    }

    // Validación de fechas
    $ven_fecha_dt = new DateTime($ven_fecha);
    $ven_fecha_venc_dt = new DateTime($ven_fecha_venc);

    if ($ven_fecha_venc_dt < $ven_fecha_dt) {
        $_SESSION['mensaje'] = "La fecha de vencimiento no puede ser anterior a la fecha de venta.";
        header("location: ventas_index.php");
        exit;
    }

    // Procesamiento del detalle
    $detalle = $_POST['detalle'] ?? [];
    $cantidades = [];
    $precios = [];
    $descuentos = [];
    $subtotales = [];
    $ivas = [];
    $totales = [];
    $tipos = [];
    $articulos = [];

    foreach ($detalle as $item) {
        $cantidad = floatval($item['cantidad'] ?? 0);
        $precio = floatval($item['precio_unitario'] ?? 0);
        $desc = floatval($item['descuento'] ?? 0);
        $tipo_cod = intval($item['tipo_cod'] ?? 0); // Asegúrate que el frontend envíe este campo
        $iva_porcentaje = floatval($item['iva_porcentaje'] ?? 0); // También debe venir del frontend
        
        $subtotal = $cantidad * $precio * (1 - $desc / 100);
        $iva_monto = $subtotal * $iva_porcentaje / 100;
        $total_item = $subtotal + $iva_monto;
        
        $cantidades[] = $cantidad;
        $precios[] = $precio;
        $descuentos[] = $desc;
        $subtotales[] = $subtotal;
        $ivas[] = $iva_monto;
        $totales[] = $total_item;
        $articulos[] = intval($item['art_cod']);
        $tipos[] = $tipo_cod; // Usamos el tipo_cod real del artículo
    }

    // Validación final
    if (empty($articulos)) {
        $_SESSION['mensaje'] = "Error: No hay artículos válidos en la venta";
        header("location: ventas_index.php");
        exit;
    }

    // Función para crear arrays PostgreSQL seguros
    function crearArraySQL($array, $tipo = 'numeric') {
        if (empty($array)) return 'ARRAY[]::' . $tipo . '[]';
        return 'ARRAY[' . implode(',', array_map(function($v) {
            return is_numeric($v) ? $v : "'" . pg_escape_string($v) . "'";
        }, $array)) . ']::' . $tipo . '[]';
    }

    // Sanitización de datos
    $control_id = intval($control_id);
    $cli_cod = intval($cli_cod);
    $ven_fecha = "'" . pg_escape_string($ven_fecha) . "'";
    $ven_fecha_venc = "'$ven_fecha_venc'";
    $tipo_comprobante = intval($tipo_comprobante);
    $nro_comprobante = "'" . pg_escape_string($nro_comprobante) . "'";
    $condicion_pago = intval($condicion_pago);
    $observaciones = $observaciones ? "'" . pg_escape_string($observaciones) . "'" : "NULL";

    // Construcción de la consulta SQL
    $sql = "SELECT fn_ventas(
        {$accion}::integer,
        {$control_id}::integer,
        {$cli_cod}::integer,
        {$_SESSION['emp_cod']}::integer,
        {$_SESSION['id_sucursal']}::integer,
        {$ven_fecha}::timestamp,
        {$ven_fecha_venc}::timestamp,
        {$tipo_comprobante}::integer,
        {$nro_comprobante}::varchar,
        {$condicion_pago}::integer,
        {$observaciones}::text,
        {$_SESSION['usu_cod']}::integer,
        " . crearArraySQL($cantidades) . ",
        " . crearArraySQL($precios) . ",
        " . crearArraySQL($descuentos) . ",
        " . crearArraySQL($subtotales) . ",
        " . crearArraySQL($ivas) . ",
        " . crearArraySQL($totales) . ",
        " . crearArraySQL($tipos, 'integer') . ",
        " . crearArraySQL($articulos, 'integer') . "
    ) AS resul";

    $resultado = consultas::get_datos($sql);

    if ($resultado && $resultado[0]['resul'] != null) {
        $_SESSION['mensaje'] = $resultado[0]['resul'];
    } else {
        $_SESSION['mensaje'] = "Error al procesar la venta. " . (isset($resultado[0]['resul']) ? $resultado[0]['resul'] : '');
    }
    
    header("location: ventas_index.php");
    exit;

} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    header("location: ventas_index.php");
    exit;
}