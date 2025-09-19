<?php
require 'clases/conexion.php';
session_start();

// Verificar que el usuario esté validado
if (!isset($_SESSION['usu_cod_validado'])) {
    $_SESSION['error'] = "❌ Sesión no válida. Por favor, inicie el proceso nuevamente.";
    header("Location: recuperar_contrasena.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_clave']) && isset($_POST['confirmar_clave'])) {
    $nueva_clave = trim($_POST['nueva_clave']);
    $confirmar_clave = trim($_POST['confirmar_clave']);
    $usu_cod = intval($_SESSION['usu_cod_validado']);
    
    // Validaciones
    if (empty($nueva_clave) || empty($confirmar_clave)) {
        $_SESSION['error'] = "❌ Complete todos los campos";
        header("Location: restablecer_contrasena.php");
        exit;
    }
    
    if ($nueva_clave !== $confirmar_clave) {
        $_SESSION['error'] = "❌ Las contraseñas no coinciden";
        header("Location: restablecer_contrasena.php");
        exit;
    }
    
    if (strlen($nueva_clave) < 6) {
        $_SESSION['error'] = "❌ La contraseña debe tener al menos 6 caracteres";
        header("Location: restablecer_contrasena.php");
        exit;
    }
    
    // Validar fortaleza de contraseña
    if (!preg_match('/[a-z]/', $nueva_clave) || 
        !preg_match('/[A-Z]/', $nueva_clave) || 
        !preg_match('/[0-9]/', $nueva_clave)) {
        $_SESSION['error'] = "❌ La contraseña debe contener al menos una mayúscula, una minúscula y un número";
        header("Location: restablecer_contrasena.php");
        exit;
    }
    
    // Hashear la nueva contraseña (MD5 como en tu sistema)
    $clave_hash = md5($nueva_clave);
    
    // Actualizar la contraseña en la base de datos
    $sql = "UPDATE usuarios 
            SET usu_clave = '$clave_hash',
                intentos_fallidos = 0,
                bloqueado = false,
                bloqueado_hasta = NULL,
                codigo_verificacion = NULL,
                codigo_expiracion = NULL
            WHERE usu_cod = $usu_cod
            RETURNING usu_cod";
    
    $resultado = consultas::get_datos($sql);
    
    if ($resultado && !empty($resultado)) {
        // Limpiar todas las variables de sesión de recuperación
        unset($_SESSION['usu_cod_recuperacion']);
        unset($_SESSION['usu_cod_validado']);
        unset($_SESSION['codigo_generado']);
        unset($_SESSION['expiracion']);
        
        // Mensaje de éxito
        $_SESSION['mensaje'] = "✅ Contraseña cambiada exitosamente. Ya puede iniciar sesión.";
        
        // Redirigir al login principal
        header("Location: ../lp3");
        exit;
    } else {
        $_SESSION['error'] = "❌ Error al cambiar la contraseña. Intente nuevamente.";
        header("Location: restablecer_contrasena.php");
        exit;
    }
} else {
    $_SESSION['error'] = "❌ Método no válido";
    header("Location: recuperar_contrasena.php");
    exit;
}
?>