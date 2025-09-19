<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueo de Caja</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

    .disabled-input {
        background-color: #f3f4f6 !important;
        cursor: not-allowed;
    }

    .input-currency {
        padding-left: 2rem !important;
    }

    .currency-symbol {
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    .totals-row {
        background-color: #f8f9fa;
        font-weight: bold;
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
                            <h3 class="mb-0">Generar Arqueo de Caja</h3>
                            <p class="text-muted">Resumen de movimientos y totales por forma de pago</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="arqueo_caja_index.php" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="form-card">
                        <form id="arqueoForm" action="arqueo_control.php" method="post" class="form-horizontal">
                            <input type="hidden" name="accion" value="generar">
                            <input type="hidden" name="id_caja" id="id_caja"
                                value="<?php echo $_GET['id_caja'] ?? ''; ?>">

                            <!-- Información de Caja -->
                            <h4 class="section-title">Información de Caja</h4>

                            <div class="row">
                                <!-- Fecha -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control disabled-input"
                                        disabled>
                                </div>

                                  <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Caja:</label>
                                        <select name="banco_id" class="form-control" required>
                                            <option value="">Seleccione la caja</option>
                                            <!-- Opciones de caja -->
                                        </select>
                                    </div>
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

                            <!-- Totales por Forma de Pago -->
                            <h4 class="section-title">Totales por Forma de Pago</h4>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Forma de Pago</th>
                                            <th>Cantidad de Operaciones</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Efectivo -->
                                        <tr>
                                            <td>Efectivo</td>
                                            <td><span id="cant_efectivo">0</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">₲</span>
                                                    <input type="number" step="0.01" name="total_efectivo"
                                                        id="total_efectivo" class="form-control" required>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Tarjetas -->
                                        <tr>
                                            <td>Tarjetas</td>
                                            <td><span id="cant_tarjetas">0</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">₲</span>
                                                    <input type="number" step="0.01" name="total_tarjetas"
                                                        id="total_tarjetas" class="form-control" required>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Cheques -->
                                        <tr>
                                            <td>Cheques</td>
                                            <td><span id="cant_cheques">0</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">₲</span>
                                                    <input type="number" step="0.01" name="total_cheques"
                                                        id="total_cheques" class="form-control" required>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Otros -->
                                        <tr>
                                            <td>Otros</td>
                                            <td><span id="cant_otros">0</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">₲</span>
                                                    <input type="number" step="0.01" name="total_otros" id="total_otros"
                                                        class="form-control" required>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Total General -->
                                        <tr class="totals-row">
                                            <td><strong>Total General</strong></td>
                                            <td><span id="cant_total">0</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">₲</span>
                                                    <input type="number" step="0.01" name="total_general"
                                                        id="total_general" class="form-control disabled-input" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Observaciones -->
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3"
                                        maxlength="255"></textarea>
                                    <small class="text-muted">Máximo 255 caracteres</small>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="button" id="calcularBtn" class="btn btn-info mr-2">
                                    <i class="fa fa-calculator"></i> Calcular Totales
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Guardar Arqueo
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
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar datos de la caja
            const idCaja = document.getElementById('id_caja').value;
            if (idCaja) {
                fetch(`get_caja_data.php?id=${idCaja}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('fecha').value = data.fecha;
                        document.getElementById('hora_apertura').value = data.hora_apertura;
                        document.getElementById('monto_apertura').value = data.monto_apertura;
                        document.getElementById('usuario_apertura').value = data.usuario_apertura;
                    });
            }

            // Botón para calcular totales
            document.getElementById('calcularBtn').addEventListener('click', function() {
                // Simulación de cálculo - en producción harías una llamada AJAX
                calcularTotales();
            });

            // Auto-calcular total general cuando cambian los parciales
            ['total_efectivo', 'total_tarjetas', 'total_cheques', 'total_otros'].forEach(id => {
                document.getElementById(id).addEventListener('change', calcularTotalGeneral);
            });

            function calcularTotales() {
                // En una implementación real, esto haría una llamada AJAX al servidor
                // para obtener los totales reales de la base de datos

                // Simulación de datos
                const mockData = {
                    efectivo: {
                        cantidad: 15,
                        total: 1250000.00
                    },
                    tarjetas: {
                        cantidad: 8,
                        total: 450000.00
                    },
                    cheques: {
                        cantidad: 2,
                        total: 300000.00
                    },
                    otros: {
                        cantidad: 3,
                        total: 150000.00
                    }
                };

                // Actualizar la interfaz
                document.getElementById('cant_efectivo').textContent = mockData.efectivo.cantidad;
                document.getElementById('total_efectivo').value = mockData.efectivo.total.toFixed(2);

                document.getElementById('cant_tarjetas').textContent = mockData.tarjetas.cantidad;
                document.getElementById('total_tarjetas').value = mockData.tarjetas.total.toFixed(2);

                document.getElementById('cant_cheques').textContent = mockData.cheques.cantidad;
                document.getElementById('total_cheques').value = mockData.cheques.total.toFixed(2);

                document.getElementById('cant_otros').textContent = mockData.otros.cantidad;
                document.getElementById('total_otros').value = mockData.otros.total.toFixed(2);

                // Calcular total general
                calcularTotalGeneral();

                // Actualizar cantidad total
                const totalOps = mockData.efectivo.cantidad + mockData.tarjetas.cantidad +
                    mockData.cheques.cantidad + mockData.otros.cantidad;
                document.getElementById('cant_total').textContent = totalOps;
            }

            function calcularTotalGeneral() {
                const efectivo = parseFloat(document.getElementById('total_efectivo').value) || 0;
                const tarjetas = parseFloat(document.getElementById('total_tarjetas').value) || 0;
                const cheques = parseFloat(document.getElementById('total_cheques').value) || 0;
                const otros = parseFloat(document.getElementById('total_otros').value) || 0;

                const total = efectivo + tarjetas + cheques + otros;
                document.getElementById('total_general').value = total.toFixed(2);
            }
        });
        </script>
    </div>
</body>

</html>