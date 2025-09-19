<?php
session_start();
if (!isset($_SESSION['requiere_verificacion'])) {
    header("location:index.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf8">
    <title>Verificación de Seguridad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <style>
        body {
            background-image: url('img/login_carpinteria_familia.webp');
            background-size: cover;
            background-position: center;
            padding-top: 110px;
            padding-bottom: 120px;
        }
        .verificacion {
            max-width: 400px;
            padding: 15px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verificacion">
            <h3 class="text-center">Verificación de Seguridad</h3>
            <p class="text-center">Ingresa el código enviado a tu email</p>
            
            <form action="validar_codigo.php" method="post">
                <div class="form-group">
                    <input type="text" name="codigo" class="form-control" 
                           placeholder="Código de 6 dígitos" required autofocus maxlength="6">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Verificar</button>
                <a href="index.php" class="btn btn-default btn-block">Cancelar</a>
            </form>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger mt-3">
                    <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>