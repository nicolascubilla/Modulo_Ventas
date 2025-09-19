<?php 
session_start();
if(!isset($_SESSION['usu_cod_validado'])) {
    header("Location: recuperar_contrasena.php");
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva Contraseña - Carpintería Familia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: url('img/login_carpinteria_familia.webp') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        #sha {
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        #avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: block;
            border: 3px solid #007bff;
            padding: 5px;
        }
        h3 {
            margin-bottom: 25px;
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-control {
            border-radius: 12px;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 2;
        }
        .btn {
            border-radius: 12px;
            font-size: 18px;
            padding: 15px;
            font-weight: 600;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        .requisitos {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link a:hover {
            color: #007bff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container" id="sha">
        <div class="text-center">
            <img src="img/avatar.png" id="avatar" alt="Usuario" class="img-fluid">
            <h3><i class="fas fa-key"></i> Nueva Contraseña</h3>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <form id="passwordForm" action="procesar_nueva_contrasena.php" method="post">
            <div class="form-group">
                <input type="password" name="nueva_clave" id="nuevaClave" class="form-control" 
                       placeholder="🔒 Nueva contraseña" required minlength="6"
                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$">
                <span class="password-toggle" onclick="togglePassword('nuevaClave')">
                    <i class="fas fa-eye"></i>
                </span>
                <div class="password-strength" id="passwordStrength"></div>
                <div class="requisitos">
                    <small>Mínimo 6 caracteres, 1 mayúscula, 1 minúscula, 1 número</small>
                </div>
            </div>

            <div class="form-group">
                <input type="password" name="confirmar_clave" id="confirmarClave" class="form-control" 
                       placeholder="🔒 Confirmar contraseña" required minlength="6">
                <span class="password-toggle" onclick="togglePassword('confirmarClave')">
                    <i class="fas fa-eye"></i>
                </span>
                <div id="passwordMatch" class="requisitos"></div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-save"></i> Cambiar Contraseña
            </button>
        </form>

        <div class="back-link">
            <a href="recuperar_contrasena.php">
                <i class="fas fa-arrow-left"></i> Volver atrás
            </a>
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Validación de fortaleza de contraseña
        document.getElementById('nuevaClave').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            let strength = 0;

            if (password.length >= 6) strength += 20;
            if (/[a-z]/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 20;

            strengthBar.style.width = strength + '%';
            
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength < 80) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
        });

        // Validación de coincidencia de contraseñas
        document.getElementById('confirmarClave').addEventListener('input', function() {
            const password = document.getElementById('nuevaClave').value;
            const confirmPassword = this.value;
            const matchText = document.getElementById('passwordMatch');

            if (confirmPassword === '') {
                matchText.innerHTML = '';
            } else if (password === confirmPassword) {
                matchText.innerHTML = '<small style="color: #28a745;"><i class="fas fa-check-circle"></i> Las contraseñas coinciden</small>';
            } else {
                matchText.innerHTML = '<small style="color: #dc3545;"><i class="fas fa-times-circle"></i> Las contraseñas no coinciden</small>';
            }
        });

        // Validación del formulario
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const password = document.getElementById('nuevaClave').value;
            const confirmPassword = document.getElementById('confirmarClave').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('❌ Las contraseñas no coinciden');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('❌ La contraseña debe tener al menos 6 caracteres');
                return false;
            }

            if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)) {
                e.preventDefault();
                alert('❌ La contraseña debe contener al menos una mayúscula, una minúscula y un número');
                return false;
            }
        });

        // Desaparecer alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>