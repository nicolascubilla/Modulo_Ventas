<?php
require 'clases/conexion.php';

session_start();

if (!isset($_SESSION['requiere_verificacion'])) {
    header("location:index.php");
    exit();
}

$usuario = $_SESSION['requiere_verificacion'];
$codigo = $_POST['codigo'];

// Verificar código
$sql = "SELECT * FROM usuarios 
        WHERE usu_nick = '$usuario' 
        AND codigo_verificacion = '$codigo' 
        AND codigo_expiracion > NOW()";

$resultado = consultas::get_datos($sql);

if ($resultado) {
    // Código válido, permitir login
    $sql_limpiar = "UPDATE usuarios SET 
                   intentos_fallidos = 0,
                   codigo_verificacion = NULL,
                   codigo_expiracion = NULL
                   WHERE usu_nick = '$usuario'";
    
    consultas::ejecutar_sql($sql_limpiar);
    
    // Obtener datos del usuario
    $sql_usuario = "SELECT * FROM v_usuarios WHERE usu_nick = '$usuario'";
    $usuario_data = consultas::get_datos($sql_usuario);
    
    // Configurar sesión
    $_SESSION['usu_cod'] = $usuario_data[0]['usu_cod'];
    $_SESSION['usu_nick'] = $usuario_data[0]['usu_nick'];
    $_SESSION['emp_cod'] = $usuario_data[0]['emp_cod'];
    $_SESSION['nombres'] = $usuario_data[0]['empleado'];
    $_SESSION['gru_cod'] = $usuario_data[0]['gru_cod'];
    $_SESSION['grupo'] = $usuario_data[0]['gru_nombre'];
    $_SESSION['id_sucursal'] = $usuario_data[0]['id_sucursal'];
    $_SESSION['sucursal'] = $usuario_data[0]['suc_descri'];
    
    unset($_SESSION['requiere_verificacion']);
    header('location:menu.php');
} else {
    $_SESSION['error'] = "Código inválido o expirado";
    header("location:verificacion.php");
}
exit();
?>