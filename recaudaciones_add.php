<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Recaudación</title>
    <?php require 'menu/css_lte.ctp'; ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Registrar Recaudación a Depositar</h1>
            </section>

            <section class="content">
                <div class="box box-primary">
                    <div class="box-body">
                        <form id="recaudacionForm">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha Depósito:</label>
                                        <input type="date" name="fecha_deposito" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Banco Destino:</label>
                                        <select name="banco_id" class="form-control" required>
                                            <option value="">Seleccione banco</option>
                                            <!-- Opciones de bancos -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Efectivo a Depositar (₲):</label>
                                        <input type="number" step="0.01" name="monto_efectivo" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cheques a Depositar (₲):</label>
                                        <input type="number" step="0.01" name="monto_cheques" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Total Recaudación (₲):</label>
                                        <input type="number" step="0.01" name="total" class="form-control" readonly>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nro comprobante:</label>
                                        <input type="number" step="0.01" name="total" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Observaciones:</label>
                                <textarea name="observaciones" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Registrar Recaudación</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

       

  

     <script>
     $(document).ready(function() {
        // Calcular total automático
        $('input[name="monto_efectivo"], input[name="monto_cheques"]').on('change', function() {
            let efectivo = parseFloat($('input[name="monto_efectivo"]').val()) || 0;
            let cheques = parseFloat($('input[name="monto_cheques"]').val()) || 0;
            $('input[name="total"]').val((efectivo + cheques).toFixed(2));
        });

        // Validar que no supere los montos del arqueo
        $('#recaudacionForm').submit(function(e) {
            e.preventDefault();
            // Aquí iría la validación contra el arqueo
        });
     });
     </script>
     </div>
</body>

</html>