<?php
require 'clases/conexion.php'; // Incluye la conexión
session_start(); // Inicia o reanuda la sesión

try {
    // Convertir los arrays enviados por POST en formato compatible con PostgreSQL
    function format_array($array) {
        return $array ? "'{" . implode(',', array_map('intval', $array)) . "}'" : 'NULL';
    }

    // Procesar los arrays de materiales, cantidades, costos, etc.
    $materiales = format_array($_POST['vmaterial_id'] ?? []);
    $cantidades = format_array($_POST['vcantidad_material'] ?? []);
    $costos = format_array($_POST['vcosto_unitario'] ?? []);
    $vsubtotal = format_array($_POST['vsubtotal'] ?? []);
    $iva_5 = format_array($_POST['viva_5'] ?? []);
    $iva_10 = format_array($_POST['viva_10'] ?? []); 

    // Verificar otros datos
    $accion = $_POST['accion'] ?? null;
    $vorden_id = $_POST['vorden_id'] ?? 'NULL';
    $vprv_cod = $_POST['vprv_cod'] ?? 'NULL';
    $vfecha_emision = $_POST['vfecha_emision'] ?? null;
    $vmonto_total = $_POST['vmonto_total'] ?? 'NULL';
    $vtimbrado = $_POST['vtimbrado'] ?? 'NULL';
    if (!preg_match('/^\d{8}$/', $vtimbrado)) {
    die('El N° de timbrado debe tener exactamente 8 dígitos');
    }
    $vid_metodo_pago = $_POST['vid_metodo_pago'] ?? 'NULL';
    $vcondicion = $_POST['vcondicion'] ?? 'NULL';
    $vfact_cuota = $_POST['vfact_cuota'] ?? 'NULL';
    $vperiodicidad = $_POST['vperiodicidad'] ?? 'NULL';
    $vid_sucursal = $_POST['vid_sucursal'] ?? 'NULL';
    $vusu_cod = $_POST['vusu_cod'] ?? 'NULL';
    $vplazo = $_POST['vplazo'] ?? 'NULL'; 
    $vid_factu_proveedor = $_POST['vid_factu_proveedor'] ?? 'NULL';
    if (!preg_match('/^\d{1,13}$/', $vid_factu_proveedor)) {
    die('El N° de factura del proveedor debe tener hasta 13 dígitos');
    }
    $vdep_cod = $_POST['vdep_cod'] ?? 'NULL';
       // Si la condición es 'CONTADO', establecer vplazo como NULL
    if ($vcondicion == 'CONTADO') {
        $vplazo = 'NULL';
    }

    // Validación de fechas y periodicidad
    if (!$vfecha_emision || !$vplazo) {
        throw new Exception("Las fechas no fueron enviadas correctamente.");
    }

  // Si la condición es 'CONTADO', establecer vplazo como NULL (sin comillas)
if ($vcondicion == 'CONTADO') {
    $vplazo = "NULL";
} else {
    // Asegurarse de que vplazo sea válido y en formato de fecha si no es 'CONTADO'
    $vplazo = isset($_POST['vplazo']) ? "'{$_POST['vplazo']}'" : "NULL";
}

// Preparar llamada SQL asegurando que NULL no lleve comillas
$sql = "SELECT public.fn_factura_compras(
    $accion,
    $vorden_id,
    $vprv_cod,
    '$vfecha_emision',
    $vmonto_total,
    '$vtimbrado',
    $vid_metodo_pago,
    '$vcondicion',
    $vfact_cuota,
    $vplazo, -- Aquí el valor puede ser NULL (sin comillas)
    '$vid_factu_proveedor',
    '$vperiodicidad',
    $vid_sucursal,
    $vusu_cod,
    $materiales,  
    $cantidades,  
    $costos,      
    $vsubtotal,   
    $iva_5,       
    $iva_10,
    '$vdep_cod'
) AS resul";


    // Ejecutar la consulta
    $resultado= consultas::get_datos($sql);

    // Procesar resultado
    if($resultado[0]['resul']!=null){
        $valor= explode("*",$resultado[0]['resul']);
        $_SESSION['mensaje']=$valor[0];
        header("location:factura_compra_index.php".$valor[1]);
    }else{
       $_SESSION['mensaje']="Error al procesar ".$sql;
        header("location:factura_compra_index.php"); 
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error al procesar: " . $e->getMessage();
    header("location:factura_compra_index.php");
}

