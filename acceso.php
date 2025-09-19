<?php
session_start();
require 'clases/conexion.php';

$usuario = trim($_POST['usuario']);
$clave   = trim($_POST['clave']);

// 1. Buscar usuario en tabla real (para ver bloqueos e intentos)
$sql = "SELECT usu_cod, usu_nick, usu_clave, intentos_fallidos, bloqueado, bloqueado_hasta 
        FROM usuarios 
        WHERE usu_nick = '$usuario'";
$resultado = consultas::get_datos($sql);

if (empty($resultado)) {
    $_SESSION['error'] = "Usuario o contraseña incorrectos";
    header("location:index.php");
    exit;
}

$usuarioDB = $resultado[0];

// 2. Validar si está bloqueado
if ($usuarioDB['bloqueado'] == 't' && $usuarioDB['bloqueado_hasta'] > date('Y-m-d H:i:s')) {
    $_SESSION['error'] = "Cuenta bloqueada hasta: " . $usuarioDB['bloqueado_hasta'];
    header("location:index.php");
    exit;
}

// 3. Validar contraseña usando tu vista v_usuarios
$sqlClave = "SELECT * FROM v_usuarios 
             WHERE usu_nick = '$usuario' 
               AND usu_clave = md5('$clave')";
$resultadoClave = consultas::get_datos($sqlClave);

if (!empty($resultadoClave)) {
    // ✅ Login correcto → reiniciar intentos
    $sqlUpdate = "UPDATE usuarios 
                  SET intentos_fallidos = 0, bloqueado = false, bloqueado_hasta = NULL
                  WHERE usu_cod = " . $usuarioDB['usu_cod'];
    consultas::get_datos($sqlUpdate);

    $row = $resultadoClave[0];

    // Variables de sesión
    $_SESSION['usu_cod']   = $row['usu_cod'];
    $_SESSION['usu_nick']  = $row['usu_nick'];
    $_SESSION['emp_cod']   = $row['emp_cod'];
    $_SESSION['nombres']   = $row['empleado'];
    $_SESSION['gru_cod']   = $row['gru_cod'];
    $_SESSION['grupo']     = $row['gru_nombre'];
    $_SESSION['id_sucursal'] = $row['id_sucursal'];
    $_SESSION['sucursal']  = $row['suc_descri'];
    $_SESSION['usu_foto']  = 'img/avatar.jpg';

    header("location:menu.php");
    exit;

} else {
    // ❌ Contraseña incorrecta → sumar intentos
    $intentos = $usuarioDB['intentos_fallidos'] + 1;
    $bloqueado = 'false';
    $hasta = "NULL";

    if ($intentos >= 3) {
        $bloqueado = 'true';
        $hasta = "'" . date('Y-m-d H:i:s', strtotime('+10 minutes')) . "'";
    }

    $sqlUpdate = "UPDATE usuarios 
                  SET intentos_fallidos = $intentos, 
                      bloqueado = $bloqueado, 
                      bloqueado_hasta = $hasta
                  WHERE usu_cod = " . $usuarioDB['usu_cod'];
    consultas::get_datos($sqlUpdate);

    $_SESSION['error'] = "Usuario o contraseña incorrectos";
    header("location:index.php");
    exit;
}
?>