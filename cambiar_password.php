<?php
require 'clases/conexion.php';
session_start();

if (!isset($_SESSION['usuario_recuperacion'])) {
    header("location:recuperar_password.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $usu_cod = $_SESSION['usuario_recuperacion'];

    // Verificar el código
    $sql = "SELECT * FROM usuarios 
            WHERE usu_cod = $usu_cod 
            AND codigo_verificacion = '$codigo'
            AND codigo_expiracion > NOW()";
    
    $resultado = consultas::get_datos($sql);

    if (count($resultado) > 0) {
        // Código válido
        $_SESSION['usuario_cambio'] = $usu_cod;
        header("location:cambiar_password.php");
    } else {
        // Código inválido o expirado
        $_SESSION['codigo_error'] = "Código inválido o expirado.";
        header("location:verificar_codigo.php");
    }
    exit;
}
?>