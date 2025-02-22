<?php
session_start(); // Asegúrate de que esto esté al principio del archivo
?>
<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf8">
    <title>Acceso</title>
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
        .login {
            max-width: 400px; /* Agrandar el login */
            padding: 15px;
            margin: 0 auto;
        }
        #sha {
            max-width: 420px;
            box-shadow: 0px 0px 18px 0px rgba(48, 50, 50, 0.48);
            border-radius: 10%;
        }
        #avatar {
            width: 96px;
            height: 96px;
            margin: 0 auto 10px;
            display: block;
            border-radius: 50%;
        }
        .alert {
            margin-top: 15px;
            text-align: center; /* Centrar el texto del mensaje */
        }
        .checkbox {
            text-align: center; /* Centrar todo el bloque */
        }
    </style>
</head>
<body>
    <div class="container well" id="sha">
        <div class="row">
            <div class="col-xs-12">
                <img src="img/avatar.png" class="img-responsive" id="avatar"/>
            </div>
        </div>
        <form action="acceso.php" class="login" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="usuario" class="form-control" placeholder="Ingrese su nombre de usuario" autocomplete="off" required autofocus/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="clave" class="form-control" placeholder="Ingrese su clave de acceso" autocomplete="off" required/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Iniciar sesión</button>
        </form>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']); // Eliminar el mensaje después de mostrarlo
                ?>
            </div>
        <?php endif; ?>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="recuerdame"/> No cerrar sesión
            </label>
            <p class="help-block"><a href="#">¿No puede acceder a su cuenta?</a></p>
        </div>
    </div>

    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        // Desaparecer el mensaje de error después de 5 segundos
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
        });
    </script>
</body>
</html>
