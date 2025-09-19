<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de Caja</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    /* Custom styles for elements that need more specific styling */
    .disabled-input {
        background-color: #f3f4f6 !important;
        cursor: not-allowed;
    }

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

    .input-currency {
        padding-left: 2rem !important;
    }

    .currency-symbol {
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
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
                            <h3 class="mb-0">Registrar Cierre de Caja</h3>
                            <p class="text-muted">Complete los datos para cerrar la caja del día</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="apertura_caja_index.php" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="form-card">
                        <form id="cierreForm" action="cierre_control.php" method="post" class="form-horizontal"
                            novalidate>
                            <input type="hidden" name="accion" value="2">
                            <input type="hidden" name="id_apertura" id="id_apertura" value="">

                            <!-- Información de Apertura -->
                            <h4 class="section-title">Información de Apertura</h4>

                            <div class="row">
                                <!-- Fecha -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control disabled-input"
                                        disabled>
                                </div>

                                <!-- Hora Apertura -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="hora_apertura" class="form-label">Hora Apertura</label>
                                    <input type="time" name="hora_apertura" id="hora_apertura"
                                        class="form-control disabled-input" disabled>
                                </div>

                                <!-- Monto Apertura -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="monto_apertura" class="form-label">Monto Apertura</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₲</span>
                                        <input type="number" step="0.01" name="monto_apertura" id="monto_apertura"
                                            class="form-control disabled-input" disabled>
                                    </div>
                                </div>

                                <!-- Usuario Apertura -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="usuario_apertura" class="form-label">Usuario Apertura</label>
                                    <input type="text" name="usuario_apertura" id="usuario_apertura"
                                        class="form-control disabled-input" disabled>
                                </div>
                            </div>

                            <!-- Información de Cierre -->
                            <h4 class="section-title">Información de Cierre</h4>

                            <div class="row">
                                <!-- Hora Cierre -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="hora_cierre" class="form-label">Hora Cierre *</label>
                                    <input type="time" name="hora_cierre" id="hora_cierre" class="form-control"
                                        required>
                                    <div class="invalid-feedback">Por favor ingrese la hora de cierre</div>
                                </div>

                                <!-- Monto Cierre -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="monto_cierre" class="form-label">Monto Cierre *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₲</span>
                                        <input type="number" step="0.01" min="0" name="monto_cierre" id="monto_cierre"
                                            class="form-control" required>
                                    </div>
                                    <div class="invalid-feedback">El monto debe ser mayor a 0</div>
                                </div>

                                <!-- Diferencia -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="diferencia" class="form-label">Diferencia</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₲</span>
                                        <input type="number" step="0.01" name="diferencia" id="diferencia"
                                            class="form-control disabled-input" readonly>
                                    </div>
                                </div>

                                <!-- Usuario Cierre -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="usuario_cierre" class="form-label">Usuario Cierre</label>
                                    <input type="text" name="usuario_cierre" id="usuario_cierre"
                                        class="form-control disabled-input" value="<?php echo $_SESSION['usu_nick']; ?>"
                                        readonly>
                                    <input type="hidden" name="vusuario_cierre"
                                        value="<?php echo $_SESSION['usu_cod']; ?>">
                                </div>

                                <!-- Observaciones -->
                                <div class="col-12 mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="vobservaciones" id="observaciones" class="form-control" rows="3"
                                        maxlength="255"></textarea>
                                    <small class="text-muted">Máximo 255 caracteres</small>
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
            document.getElementById('cierreForm')?.addEventListener('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                this.classList.add('was-validated');
            }, false);

            // Auto-completar hora actual al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                const now = new Date();
                const timeString = now.toTimeString().substring(0, 5);
                document.getElementById('hora_cierre').value = timeString;
            });
        })();
        </script>
    </div>
</body>

</html>