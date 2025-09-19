<?php
require 'clases/conexion.php';
session_start();

// Verifica si existe el código de recuperación en la sesión
if (!isset($_SESSION['usu_cod_recuperacion'])) {
    header("Location: recuperar_contrasena.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $codigo = trim($_POST['codigo']);
    $usu_cod = intval($_SESSION['usu_cod_recuperacion']); // Sanear el ID del usuario
    
    // Prevenir SQL Injection usando consultas parametrizadas
    $sql = "SELECT * FROM usuarios 
            WHERE usu_cod = $usu_cod
            AND codigo_verificacion = '" . pg_escape_string($codigo) . "' 
            AND codigo_expiracion > NOW()";
    
    $resultado = consultas::get_datos($sql);
    
    if ($resultado && count($resultado) > 0) {
        // Guardamos que ya fue validado correctamente
        $_SESSION['usu_cod_validado'] = $usu_cod;

        // 🔒 IMPORTANTE: eliminar el código usado para que no pueda reutilizarse
        $update = "UPDATE usuarios 
                   SET codigo_verificacion = NULL, codigo_expiracion = NULL
                   WHERE usu_cod = $usu_cod";
        consultas::ejecutar_sql($update);

        header("Location: restablecer_contrasena.php");
        exit;
    } else {
        $_SESSION['error'] = "Código inválido o expirado";
        header("Location: verificar_codigo.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Debe ingresar el código";
    header("Location: verificar_codigo.php");
    exit;
}
?>
