<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agregar Nota de Débito de Venta</title>
    <?php
    session_start();
    require 'menu/css_lte.ctp';
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php require 'menu/header_lte.ctp'; ?>
    <?php require 'menu/toolbar_lte.ctp'; ?>

    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-plus"></i>
                            <h3 class="box-title">Agregar Nota de Débito de Venta</h3>
                            <div class="box-tools">
                                <a href="nota_debito_venta_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>

                        <form action="nota_debito_venta_control.php" method="post" class="form-horizontal">
                            <input type="hidden" name="accion" value="1">

                            <div class="box-body">
                                <!-- Fecha -->
                                <div class="form-group row">
                                    <label for="fecha" class="control-label col-sm-2">Fecha:</label>
                                    <div class="col-sm-4">
                                        <?php
                                        date_default_timezone_set('America/Asuncion');
                                        $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_nd");
                                        $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_nd']));
                                        ?>
                                        <input type="datetime-local" name="fecha_visible" class="form-control"
                                               value="<?php echo $fecha_formateada; ?>" disabled>
                                        <input type="hidden" name="vfecha" value="<?php echo $fecha[0]['fecha_nd']; ?>">
                                    </div>
                                </div>

                                <!-- Usuario -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-2">Usuario:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
                                        <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
                                    </div>
                                </div>

                                <!-- Cliente -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-2">Cliente:</label>
                                    <div class="col-sm-6">
                                        <?php
                                        $clientes = consultas::get_datos("SELECT cli_cod, cli_nombre FROM clientes ORDER BY cli_cod");
                                        ?>
                                        <select class="form-control select2" name="vcli_cod" required>
                                            <option value="">Seleccione un cliente</option>
                                            <?php foreach ($clientes as $c) { ?>
                                                <option value="<?php echo $c['cli_cod']; ?>">
                                                    <?php echo $c['cli_nombre']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tipo Comprobante -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-2">Tipo Comprobante:</label>
                                    <div class="col-sm-4">
                                        <?php
                                        $tipos = consultas::get_datos("SELECT id_tipo, descripcion FROM tipos_comprobante ORDER BY descripcion");
                                        ?>
                                        <select class="form-control select2" name="vid_tipo_comprobante" required>
                                            <option value="">Seleccione un tipo</option>
                                            <?php foreach ($tipos as $t) { ?>
                                                <option value="<?php echo $t['id_tipo']; ?>"><?php echo $t['descripcion']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nro Comprobante -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-2">N° Comprobante:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="vnro_comprobante" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Motivo -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-2">Motivo:</label>
                                    <div class="col-sm-8">
                                        <textarea name="vmotivo" class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>

                                <!-- Detalle -->
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <h4>Detalle de Artículos</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 10%">Código</th>
                                                <th style="width: 40%">Descripción</th>
                                                <th style="width: 15%">Cantidad</th>
                                                <th style="width: 15%">Precio Unitario</th>
                                                <th style="width: 10%">Subtotal</th>
                                                <th style="width: 10%">IVA</th>
                                                <th style="width: 10%">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody id="detalle_nd">
                                            <tr>
                                                <td colspan="7">Seleccione artículos para la nota de débito.</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Totales -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-8 text-right">Subtotal:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="vsubtotal" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-8 text-right">IVA:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="viva" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-8 text-right">Total:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="vtotal" class="form-control" disabled>
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-floppy-o"></i> Registrar
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
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
</body>
</html>
