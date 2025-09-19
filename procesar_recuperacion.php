<?php
session_start();

// Incluye PHPMailer (versión compatible con PHP 7.0)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['email'])) {
    
    // Datos del formulario
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    
    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "❌ El formato del correo electrónico no es válido";
        header("Location: recuperar_contrasena.php");
        exit;
    }
    
    // Generar código de verificación
    $codigo = rand(100000, 999999); // 6 dígitos
    $expira = date("Y-m-d H:i:s", strtotime("+10 minutes"));
    
    // Guardar en sesión
    $_SESSION['codigo_verificacion'] = $codigo;
    $_SESSION['codigo_expiracion'] = $expira;
    $_SESSION['email_usuario'] = $email;
    $_SESSION['mostrar_codigo'] = true;
    
    // Configuración para PHP 7.0
    try {
        $mail = new PHPMailer(true);
        
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nicolascubillasosa2001@gmail.com';
        $mail->Password = 'rovctomufsiykanl'; // Tu contraseña de aplicación
        $mail->SMTPSecure = 'tls'; // Para versiones antiguas
        $mail->Port = 587;
        $mail->SMTPDebug = 2; // Para depuración (0 para producción)
        
        // Configuración adicional para versiones antiguas
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        // Remitente y destinatario
        $mail->setFrom('nicolascubillasosa2001@gmail.com', 'Sistema Carpintería');
        $mail->addAddress($email, $usuario);
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body = "
            <h3>Hola $usuario</h3>
            <p>Tu código de verificación es:</p>
            <h2 style='color:#e74c3c;'>$codigo</h2>
            <p>⏰ Este código expira a las <b>$expira</b></p>
        ";
        
        // Texto alternativo
        $mail->AltBody = "Hola $usuario. Tu código de verificación es: $codigo. Este código expira a las $expira.";
        
        // Intentar enviar
        if ($mail->send()) {
            $_SESSION['mensaje'] = "✅ Se envió un correo de verificación a $email";
        } else {
            throw new Exception('No se pudo enviar el correo: ' . $mail->ErrorInfo);
        }
        
    } catch (Exception $e) {
        // Guardar en archivo local para pruebas
        $mensaje = "Fecha: " . date('Y-m-d H:i:s') . "\n";
        $mensaje .= "Para: $email\nUsuario: $usuario\nCódigo: $codigo\nExpira: $expira\n";
        $mensaje .= "Error: " . $e->getMessage() . "\n\n";
        file_put_contents("correo_simulado.txt", $mensaje, FILE_APPEND);
        
        $_SESSION['mensaje'] = "⚠️ No se pudo enviar el correo. Se guardó localmente en correo_simulado.txt";
        $_SESSION['codigo_mostrar'] = $codigo; // Para mostrar el código en la página
    }
    
    // Volver al formulario
    header("Location: procesar_nueva_contrasena.php");
    exit;
} else {
    // Si no se enviaron los datos correctamente
    $_SESSION['error'] = "❌ Debe completar todos los campos";
    header("Location: recuperar_contrasena.php");
    exit;
}
?>