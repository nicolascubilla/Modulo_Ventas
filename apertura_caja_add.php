<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Apertura Caja</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <style>
    /* Estilos mejorados */
    .form-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
    }

    .section-title {
        color: #3c8dbc;
        border-bottom: 2px solid #f4f4f4;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
        color: #555;
    }

    .btn-custom {
        background: #3c8dbc;
        color: white;
        border-radius: 4px;
        padding: 8px 15px;
        transition: all 0.3s;
    }

    .btn-custom:hover {
        background: #367fa9;
        color: white;
    }

    .disabled-input {
        background-color: #f9f9f9 !important;
        cursor: not-allowed;
    }

    /* Validación */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 5px;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h3 class="mb-0">Registrar Apertura de Caja</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="apertura_caja_index.php" class="btn btn-custom">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>

                    <!-- FORMULARIO MEJORADO -->
                    <div class="form-card">
                        <form id="aperturaForm" action="apertura_control.php" method="post" class="form-horizontal"
                            novalidate>
                            <input type="hidden" name="accion" value="1">

                            <h4 class="section-title">Información de Registro</h4>

                            <div class="row">
                                <!-- Fecha -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha *</label>
                                    <?php
                                    date_default_timezone_set('America/Asuncion');
                                    $fecha = consultas::get_datos('select CURRENT_DATE as fecha');
                                    $fecha_formateada = date('Y-m-d', strtotime($fecha[0]['fecha']));
                                    ?>
                                    <input type="date" name="fecha" class="form-control disabled-input"
                                        value="<?php echo $fecha_formateada; ?>" disabled>
                                    <input type="hidden" name="vfecha_formateada"
                                        value="<?php echo $fecha[0]['fecha']; ?>">
                                </div>

                                <!-- Hora Apertura -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="hora_apertura" class="form-label">Hora Apertura *</label>
                                    <input type="time" name="vhora_apertura" id="hora_apertura" class="form-control"
                                        value="<?php echo date('H:i'); ?>" required>
                                    <div class="invalid-feedback">Por favor ingrese la hora de apertura</div>
                                </div>

                                <!-- Monto Apertura -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="monto_apertura" class="form-label">Monto Apertura *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₲</span>
                                        <input type="number" step="0.01" min="0" name="vmonto_apertura"
                                            id="monto_apertura" class="form-control" required>
                                    </div>
                                    <div class="invalid-feedback">El monto debe ser mayor a 0</div>
                                </div>

                                <!-- Hora Cierre -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="hora_cierre" class="form-label">Hora Cierre</label>
                                    <input type="time" name="vhora_cierre" id="hora_cierre" class="form-control">
                                </div>

                                <!-- Monto Cierre -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="monto_cierre" class="form-label">Monto Cierre</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₲</span>
                                        <input type="number" step="0.01" min="0" name="vmonto_cierre" id="monto_cierre"
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- Diferencia -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="diferencia" class="form-label">Diferencia</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₲</span>
                                        <input type="number" step="0.01" name="vdiferencia" id="diferencia"
                                            class="form-control" readonly>
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="col-12 mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="vobservaciones" id="observaciones" class="form-control" rows="3"
                                        maxlength="255"></textarea>
                                    <small class="text-muted">Máximo 255 caracteres</small>
                                </div>

                                <!-- Usuario Apertura -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="usuario_apertura" class="form-label">Usuario Apertura</label>

                                    <!-- Mostrás el nick del usuario -->
                                    <input type="text" id="usuario_apertura" class="form-control disabled-input"
                                        value="<?php echo $_SESSION['usu_nick']; ?>" readonly>

                                    <!-- Enviás el código del usuario en un campo oculto -->
                                    <input type="hidden" name="vid_usuario_apertura"
                                        value="<?php echo $_SESSION['usu_cod']; ?>">
                                </div>


                                <!-- Usuario Cierre -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="usuario_cierre" class="form-label">Usuario Cierre</label>
                                    <input type="text" id="usuario_cierre" class="form-control disabled-input" readonly>
                                    <!-- Enviás el código del usuario en un campo oculto -->
                                    <input type="hidden" name="vusuario_cierre"
                                        value="<?php echo $_SESSION['usu_cod']; ?>">
                                </div>

                                <!-- Estado -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select name="vestado" id="estado" class="form-control">
                                        <option value="13" selected>ABIERTA</option>
                                        <option value="14">CERRADA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="reset" class="btn btn-secondary mr-2">
                                    <i class="fa fa-undo"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- FIN FORMULARIO -->
                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>

        <script>
        // Validación del formulario
        (function() {
            'use strict';

            // Calcula diferencia automáticamente
            document.getElementById('monto_cierre')?.addEventListener('change', function() {
                const apertura = parseFloat(document.getElementById('monto_apertura').value) || 0;
                const cierre = parseFloat(this.value) || 0;
                document.getElementById('diferencia').value = (cierre - apertura).toFixed(2);
            });

            // Validación antes de enviar
            document.getElementById('aperturaForm')?.addEventListener('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                this.classList.add('was-validated');
            }, false);

            // Auto-completar usuario cierre cuando se selecciona estado CERRADA
            document.getElementById('estado')?.addEventListener('change', function() {
                if (this.value === 'CERRADA') {
                    document.getElementById('usuario_cierre').value =
                        '<?php echo $_SESSION['usu_nick']; ?>';
                    document.getElementById('hora_cierre').value = new Date().toTimeString().substring(0,
                        5);
                }
            });
        })();
        </script>
    </div>
</body>

</html>