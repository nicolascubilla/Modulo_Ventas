<?php
require 'conexion.php';
session_start();

if(!isset($_SESSION['usu_cod_validado'])) {
    header("Location: recuperar_contrasena.php");
    exit;
}

if(isset($_POST['nueva_clave']) && isset($_POST['confirmar_clave'])) {
    $nueva_clave = trim($_POST['nueva_clave']);
    $confirmar_clave = trim($_POST['confirmar_clave']);
    $usu_cod = $_SESSION['usu_cod_validado'];
    
    // Verificar que las contraseñas coincidan
    if($nueva_clave !== $confirmar_clave) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header("Location: restablecer_contrasena.php");
        exit;
    }
    
    // Hash de la nueva contraseña
    $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña en la base de datos
    $sql = "UPDATE usuarios SET usu_clave = $1, intentos_fallidos = 0, bloqueado = false, bloqueado_hasta = NULL, codigo_verificacion = NULL, codigo_expiracion = NULL WHERE usu_cod = $2";
    $result = pg_query_params($conn, $sql, array($clave_hash, $usu_cod));
    
    if($result) {
        // Limpiar variables de sesión
        unset($_SESSION['usu_cod_recuperacion']);
        unset($_SESSION['usu_cod_validado']);
        
        $_SESSION['mensaje'] = "Contraseña restablecida correctamente. Ya puede iniciar sesión.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Error al restablecer la contraseña";
        header("Location: restablecer_contrasena.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Datos incompletos";
    header("Location: restablecer_contrasena.php");
    exit;
}
?>