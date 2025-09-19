<?php
require 'clases/conexion.php';
session_start();

if (!isset($_SESSION['usuario_cambio'])) {
    header("location:recuperar_password.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nueva_clave = $_POST['nueva_clave'];
    $confirmar_clave = $_POST['confirmar_clave'];
    $usu_cod = $_SESSION['usuario_cambio'];

    if ($nueva_clave !== $confirmar_clave) {
        $_SESSION['password_error'] = "Las contraseñas no coinciden.";
        header("location:cambiar_password.php");
        exit;
    }

    if (strlen($nueva_clave) < 6) {
        $_SESSION['password_error'] = "La contraseña debe tener al menos 6 caracteres.";
        header("location:cambiar_password.php");
        exit;
    }

    // Actualizar contraseña y limpiar códigos
    $clave_md5 = md5($nueva_clave);
    $update = "UPDATE usuarios 
               SET usu_clave = '$clave_md5',
                   intentos_fallidos = 0,
                   bloqueado = FALSE,
                   bloqueado_hasta = NULL,
                   codigo_verificacion = NULL,
                   codigo_expiracion = NULL
               WHERE usu_cod = $usu_cod";
    
    if (consultas::ejecutar_sql($update)) {
        // Limpiar sesiones
        unset($_SESSION['usuario_recuperacion']);
        unset($_SESSION['usuario_cambio']);
        
        $_SESSION['success_msg'] = "Contraseña cambiada exitosamente. Ya puedes iniciar sesión.";
        header("location:index.php");
    } else {
        $_SESSION['password_error'] = "Error al cambiar la contraseña.";
        header("location:cambiar_password.php");
    }
    exit;
}
?>