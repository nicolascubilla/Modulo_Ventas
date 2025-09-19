<?php
session_start();
if(!isset($_SESSION['usu_cod_recuperacion'])) {
    header("Location: recuperar_contrasena.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf8">
    <title>Verificar Código</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <style>
        body {
            background-image: url('img/login_carpinteria_familia.webp');
            background-size: cover;
            background-position: center;
            padding-top: 90px; /* Reducido de 110px */
            padding-bottom: 100px; /* Reducido de 120px */
        }
        .login {
            max-width: 400px;
            padding: 15px;
            margin: 0 auto;
        }
        #sha {
            max-width: 420px;
            box-shadow: 0px 0px 18px 0px rgba(48, 50, 50, 0.48);
            border-radius: 10%;
        }
        #avatar {
            width: 70px; /* Reducido de 96px */
            height: 70px; /* Reducido de 96px */
            margin: 0 auto 10px;
            display: block;
            border-radius: 50%;
        }
        .alert {
            margin-top: 15px;
            text-align: center;
        }
        .page-title {
            font-size: 20px; /* Título más compacto */
            margin: 5px 0 10px 0;
        }
        .page-subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container well" id="sha">
        <div class="row">
            <div class="col-xs-12">
                <!-- LOGO MÁS PEQUEÑO -->
                <img src="img/avatar.png" class="img-responsive" id="avatar"/>
                <h3 class="text-center page-title">Verificar Código</h3>
                <p class="text-center page-subtitle">Ingrese el código que se generó anteriormente</p>
            </div>
        </div>
        
        <form action="procesar_verificacion.php" class="login" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="codigo" class="form-control" 
                       placeholder="Ingrese el código de 6 dígitos" 
                       autocomplete="off" required autofocus
                       maxlength="6" pattern="[0-9]{6}" title="Código de 6 dígitos"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">
                ✅ Verificar Código
            </button>
        </form>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-info" role="alert">
                <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
                ?>
            </div>
        <?php endif; ?>

        <div class="text-center" style="margin-top: 20px;">
            <a href="recuperar_contrasena.php" class="btn btn-default btn-sm">
                ↩️ Volver atrás
            </a>
        </div>
    </div>

    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            // Desaparecer mensajes después de 5 segundos
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
            
            // Validar que solo se ingresen números
            $('input[name="codigo"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
</body>
</html>