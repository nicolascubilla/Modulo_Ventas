<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agregar Nota de Crédito</title>
    <?php session_start(); require 'menu/css_lte.ctp'; ?>
    <style>
        .form-group { margin-top: 15px; }
        .control-label { font-weight: bold; }
        .table th, .table td { text-align: center; vertical-align: middle; }
        .table th { background-color: #f4f4f4; }
        .table { margin-top: 15px; }
        .section-title { margin-top: 25px; font-size: 2.0rem; font-weight: bold; text-decoration: underline; }
        .highlight { background-color: #d4edda; }
        .btn-submit { margin-top: 20px; }
        #detalle_orden td { font-size: 1.5rem; }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h2 class="box-title">Agregar Nota de Crédito</h2>
                                <div class="box-tools">
                                    <a href="nota_credito_compras_index.php" class="btn btn-primary btn-md">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>

                            <form action="nota_credito_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1">
                                <div class="box-body">
                                    <!-- Sección 1: Selección de Factura -->
                                    <div class="section-title">Datos de la Factura</div>
                                    <div class="form-group row">
                                        <label for="factura" class="col-lg-2 control-label">Seleccionar Factura:</label>
                                        <div class="col-lg-4">
                                            <select class="form-control select2" name="vid_factura" id="factura" onchange="cargarfactura(this.value)" required>
                                                <option value="">Seleccione una Factura</option>
                                                <?php 
                                                $factura = consultas::get_datos("SELECT * FROM v_factura_nota_credito ORDER BY id_factura DESC");
                                                foreach ($factura as $factu) { ?>
                                                    <option value="<?php echo $factu['id_factura']; ?>">
                                                        <?php echo "N°: " . $factu['id_factura'] . " - Fecha: " . $factu['fecha_emision']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <label for="id_factu_proveedor" class="col-lg-2 control-label">Factura del Proveedor:</label>
                                        <div class="col-lg-4">
                                            <input type="text" id="id_factu_proveedor" name="vid_factu_proveedor" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Sección 2: Información General -->
                                    <div class="section-title">Información del Proveedor y Usuario</div>
                                    <div class="form-group row">
                                        <label for="prv_nombre" class="col-lg-2 control-label">Proveedor:</label>
                                        <div class="col-lg-4">
                                            <input type="text" id="prv_nombre" name="prv_nombre" class="form-control" readonly>
                                            <input type="hidden" id="prv_cod" name="vprv_cod">
                                        </div>

                                        <label for="sucursal" class="col-lg-2 control-label">Sucursal:</label>
                                        <div class="col-lg-4">
                                            <input type="text" id="sucursal" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
                                            <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="usuario" class="col-lg-2 control-label">Usuario:</label>
                                        <div class="col-lg-4">
                                            <input type="text" id="usuario" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
                                            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
                                        </div>

                                        <label for="fecha_nota" class="col-lg-2 control-label">Fecha Nota:</label>
                                        <div class="col-lg-4">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_nota");
                                            $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_nota']));
                                            ?>
                                            <input type="datetime-local" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
                                            <input type="hidden" name="vfecha_nota" value="<?php echo $fecha[0]['fecha_nota']; ?>">
                                        </div>
                                    </div>

                                    <!-- Sección 3: Monto Total y Timbrado -->
                                    <div class="section-title">Detalles Financieros</div>
                                    <div class="form-group row">
                                        <label for="total" class="col-lg-2 control-label">Monto Total:</label>
                                        <div class="col-lg-4">
                                            <input type="text" id="total" name="vmonto_nota" class="form-control">
                                        </div>

                                        <label for="timbrado" class="col-lg-2 control-label">N° Timbrado:</label>
                                        <div class="col-lg-4">
                                            <input type="text" id="timbrado" name="vtimbrado" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Sección 4: Motivo de la Nota de Crédito -->
                                    <div class="section-title">Motivo</div>
                                    <div class="form-group row">
                                        <label for="motivo" class="col-lg-2 control-label">Motivo:</label>
                                        <div class="col-lg-10">
                                            <textarea id="motivo" name="vmotivo" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Sección 5: Detalles de la Orden -->
                                    <div class="section-title">Detalles de la Factura</div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>N° Cuota</th>
                                                    <th>Monto Cuota</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th>Saldo Cuota</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detalle_orden">
                                                <tr>
                                                    <td colspan="5">Seleccione una factura para cargar el detalle.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary btn-submit pull-right">
                                        <i class="fa fa-save"></i> Registrar Nota de Crédito
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>

    <script>
        $(document).ready(function() {
            $('#factura').select2({ width: 'resolve', placeholder: 'Seleccione una factura' });
        });

        function cargarfactura(id_factura) {
            if (id_factura) {
                $.ajax({
                    url: "get_factura_nota_credito_compra.php",
                    type: "POST",
                    dataType: "json",
                    data: { id_factura: id_factura },
                    success: function(response) {
                        $("#prv_nombre").val(response.razon_social);
                        $("#prv_cod").val(response.prv_cod);
                        $("#total").val(response.total);
                        $("#id_factu_proveedor").val(response.id_factu_proveedor);
                        $("#timbrado").val(response.timbrado);
                        $("#detalle_orden").html(response.detalles);
                    },
                    error: function() {
                        console.error("Error al cargar los datos de la orden.");
                    }
                });
            } else {
                $("#detalle_orden").html('<tr><td colspan="5">Debe seleccionar una factura.</td></tr>');
                $("#prv_nombre").val('');
            }
        }
    </script>
</body>
</html>
