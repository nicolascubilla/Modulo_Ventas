<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agregar Nota de Remisión de Venta</title>
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
                            <h3 class="box-title">Agregar Nota de Remisión de Venta</h3>
                            <div class="box-tools">
                                <a href="nota_remision_venta_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>

                        <form action="nota_remision_venta_control.php" method="post" class="form-horizontal">
                            <input type="hidden" name="accion" value="1">

                            <div class="box-body">
                                <!-- Fecha -->
                                <div class="form-group row">
                                    <label for="fecha" class="control-label col-sm-2">Fecha:</label>
                                    <div class="col-sm-4">
                                        <?php
                                        date_default_timezone_set('America/Asuncion');
                                        $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_rem");
                                        $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_rem']));
                                        ?>
                                        <input type="datetime-local" name="fecha_visible" class="form-control"
                                               value="<?php echo $fecha_formateada; ?>" disabled>
                                        <input type="hidden" name="vfecha" value="<?php echo $fecha[0]['fecha_rem']; ?>">
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
                                           
                                        </select>
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="form-group row">
                                    <label class="control-label col-sm-2">Observaciones:</label>
                                    <div class="col-sm-8">
                                        <textarea name="vobservaciones" class="form-control" rows="2"
                                                  placeholder="Ingrese observaciones..."></textarea>
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
                                                <th style="width: 55%">Artículo</th>
                                                <th style="width: 15%">Cantidad</th>
                                                <th style="width: 10%">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody id="detalle_remision">
                                            <tr>
                                                <td colspan="4">Seleccione artículos para la nota de remisión.</td>
                                            </tr>
                                            </tbody>
                                        </table>
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
