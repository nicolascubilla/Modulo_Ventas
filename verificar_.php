<?php
if(isset($_POST['codigo'], $_POST['nueva_clave'], $_POST['email'])){
    $codigo = $_POST['codigo'];
    $nueva_clave = password_hash($_POST['nueva_clave'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $sql = "SELECT * FROM usuarios WHERE email = $1 AND codigo_verificacion = $2 AND codigo_expiracion > now()";
    $res = pg_query_params($conn, $sql, array($email, $codigo));

    if($row = pg_fetch_assoc($res)){
        $sql_update = "UPDATE usuarios SET usu_clave = $1, codigo_verificacion = NULL, codigo_expiracion = NULL WHERE email = $2";
        pg_query_params($conn, $sql_update, array($nueva_clave, $email));
        echo "Contraseña restablecida con éxito";
    } else {
        echo "Código inválido o expirado";
    }
}
?>
