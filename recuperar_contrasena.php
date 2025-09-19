<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf8">
    <title>Recuperar Contraseña</title>
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
            width: 96px;
            height: 96px;
            margin: 0 auto 10px;
            display: block;
            border-radius: 50%;
        }
        .alert {
            margin-top: 15px;
            text-align: center;
        }
        .codigo-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #6c757d;
            margin: 20px 0;
            text-align: center;
        }
        .codigo-numero {
            font-size: 32px;
            font-weight: bold;
            color: #e74c3c;
            letter-spacing: 5px;
        }
    </style>
</head>
<body>
    <div class="container well" id="sha">
        <div class="row">
            <div class="col-xs-12">
                <img src="img/avatar.png" class="img-responsive" id="avatar"/>
                <h3 class="text-center">Recuperar Contraseña</h3>
                
                <?php if (isset($_SESSION['mostrar_codigo']) && $_SESSION['mostrar_codigo']): ?>
                    <!-- MOSTRAR CÓDIGO DE VERIFICACIÓN -->
                    <div class="codigo-container">
                        <h4>🔐 Código de Verificación</h4>
                        <div class="codigo-numero">
                            <?php echo $_SESSION['codigo_verificacion']; ?>
                        </div>
                        <p>⏰ Válido hasta: <?php echo $_SESSION['codigo_expiracion']; ?></p>
                        <p><small>Ingrese este código en el formulario de verificación</small></p>
                    </div>
                    
                    <div class="text-center" style="margin: 20px 0;">
                        <a href="procesar_nueva_contrasena.php" class="btn btn-success btn-lg">
                            ➡️ Ir a Verificar Código
                        </a>
                    </div>
                    
                    <?php unset($_SESSION['mostrar_codigo']); ?>
                <?php else: ?>
                    <!-- FORMULARIO NORMAL -->
                    <form action="procesar_recuperacion.php" class="login" method="post">
                        <div class="form-group has-feedback">
                            <input type="text" name="usuario" class="form-control" 
                                   placeholder="Ingrese su nombre de usuario" autocomplete="off" required autofocus/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="email" name="email" class="form-control" 
                                   placeholder="Ingrese su email registrado" autocomplete="off" required/>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Generar Código de Verificación
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['mensaje']) && !isset($_SESSION['mostrar_codigo'])): ?>
            <div class="alert alert-info" role="alert">
                <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
                ?>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="index.php">Volver al login</a>
        </div>
    </div>

    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
        });
    </script>
</body>
</html>