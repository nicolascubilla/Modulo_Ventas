<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Cobranza</title>
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

    .conditional-field {
        display: none;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Registrar Cobranza</h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                    <li><a href="cobranzas_listado.php">Cobranzas</a></li>
                    <li class="active">Nueva Cobranza</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos de la Cobranza</h3>
                            </div>
                            <form id="cobranzaForm" action="cobranza_guardar.php" method="post">
                                <input type="hidden" name="cta_cod" id="cta_cod"
                                    value="<?= $_GET['cuenta_id'] ?? '' ?>">

                                <div class="box-body">
                                    <!-- Información de la Cuenta -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <input type="text" class="form-control disabled-input"
                                                    id="cliente_nombre" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Saldo Pendiente</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">₲</span>
                                                    <input type="text" class="form-control disabled-input"
                                                        id="saldo_pendiente" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha Vencimiento</label>
                                                <input type="text" class="form-control disabled-input"
                                                    id="fecha_vencimiento" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detalle de Cobranza -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha Cobro *</label>
                                                <input type="date" name="fecha" class="form-control" required
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Monto *</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">₲</span>
                                                    <input type="number" step="0.01" name="monto" id="monto"
                                                        class="form-control" required>
                                                </div>
                                                <small class="text-muted">Monto a cobrar</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Forma de Pago *</label>
                                                <select name="id_forma_pago" id="forma_pago" class="form-control"
                                                    required>
                                                    <?php foreach($formas_pago as $fp): ?>
                                                    <option value="<?= $fp['id_forma'] ?>"
                                                        data-tipo="<?= $fp['descripcion'] ?>">
                                                        <?= $fp['descripcion'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-lg-4">
            <label for="vusuario" class="control-label">Usuario:</label>
            <input type="text" id="vusuario" name="vusuario_visible" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" readonly>
            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
        </div>
                                    </div>

                                    <!-- Campos condicionales para tarjetas -->
                                    <div id="campos_tarjeta" class="conditional-field">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>N° Tarjeta/Lote</label>
                                                    <input type="text" name="num_tarjeta" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cantidad de Cuotas</label>
                                                    <input type="number" name="cuotas" class="form-control" min="1"
                                                        value="1">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tarjeta</label>
                                                    <select name="tipo_tarjeta" class="form-control">
                                                        <option value="VISA">VISA</option>
                                                        <option value="MASTERCARD">MASTERCARD</option>
                                                        <option value="AMEX">AMERICAN EXPRESS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campos condicionales para cheques -->
                                    <div id="campos_cheque" class="conditional-field">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>N° Cheque</label>
                                                    <input type="text" name="num_cheque" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Fecha Cobro Cheque</label>
                                                    <input type="date" name="fecha_cobro_cheque" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Banco Emisor</label>
                                                    <select name="banco_emisor" class="form-control">
                                                        <option value="BANCO NACIONAL">BANCO NACIONAL</option>
                                                        <option value="BANCO CONTINENTAL">BANCO CONTINENTAL</option>
                                                        <option value="BANCO ITAÚ">BANCO ITAÚ</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <textarea name="observaciones" class="form-control" rows="2"
                                            maxlength="255"></textarea>
                                        <small class="text-muted">Máximo 255 caracteres</small>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <a href="cobranzas_listado.php" class="btn btn-default">Cancelar</a>
                                    <button type="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-save"></i> Registrar Cobranza
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
    <script>
    $(document).ready(function() {
        // Mostrar campos específicos según forma de pago
        $('#forma_pago').change(function() {
            const formaPago = $(this).find(':selected').data('tipo');
            $('.conditional-field').hide();

            if (formaPago.includes('Tarjeta')) {
                $('#campos_tarjeta').show();
            } else if (formaPago.includes('Cheque')) {
                $('#campos_cheque').show();
            }
        }).trigger('change');

        // Validar monto no exceda saldo
        $('#monto').change(function() {
            const monto = parseFloat($(this).val()) || 0;
            const saldo = parseFloat($('#saldo_pendiente').val()) || 0;

            if (monto > saldo) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El monto no puede superar el saldo pendiente de ₲' + saldo.toFixed(2)
                });
                $(this).val(saldo.toFixed(2));
            }
        });

        // Cargar datos de la cuenta si viene con parámetro
        const cuentaId = $('#cta_cod').val();
        if (cuentaId) {
            $.ajax({
                url: `cargar_cuenta.php?id=${cuentaId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#cliente_nombre').val(data.cliente);
                    $('#saldo_pendiente').val(data.saldo.toFixed(2));
                    $('#fecha_vencimiento').val(data.vencimiento);
                    $('#monto').val(data.saldo.toFixed(2));
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la información de la cuenta'
                    });
                }
            });
        }

        // Validación del formulario
        $('#cobranzaForm').submit(function(e) {
            const monto = parseFloat($('#monto').val()) || 0;
            if (monto <= 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El monto debe ser mayor a cero'
                });
            }
        });
    });
    </script>
</body>

</html>