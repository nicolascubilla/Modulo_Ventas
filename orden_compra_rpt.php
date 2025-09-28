<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <title>LP3 - Informe Órdenes de Compra</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start(); /* Reanudar sesión */
        require 'menu/css_lte.ctp';  /* ARCHIVOS CSS */
        ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!-- CABECERA -->
            <?php require 'menu/toolbar_lte.ctp'; ?><!-- MENÚ PRINCIPAL -->

            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-shopping-cart"></i>
                                    <h3 class="box-title">Informe de Órdenes de Compra</h3>
                                </div>

                                <div class="box-body">
                                    <form action="orden_compra_informe.php" method="GET" 
                                          class="form-horizontal" target="_blank">
                                        <div class="box-body">
                                            <!-- ================= OPCIONES / FILTROS ================= -->
                                            <div class="row">
                                                <!-- FILTRO: RANGO DE FECHAS -->
                                                <div class="col-lg-4 col-md-4 col-sm-6">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading"><strong>Rango de Fechas</strong></div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-lg-4">Desde:</label>
                                                                <div class="col-lg-8">
                                                                    <input type="date" name="fecha_desde" class="form-control" required 
                                                                           value="<?= date('Y-m-01') ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-lg-4">Hasta:</label>
                                                                <div class="col-lg-8">
                                                                    <input type="date" name="fecha_hasta" class="form-control" required
                                                                           value="<?= date('Y-m-d') ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- FILTRO: ESTADO -->
                                                <div class="col-lg-4 col-md-4 col-sm-6">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading"><strong>Estado</strong></div>
                                                        <div class="panel-body">
                                                            <?php
                                                            $estados = consultas::get_datos("SELECT * FROM estado WHERE id_estado IN (1,2,14) ORDER BY id_estado");
                                                            ?>
                                                            <select class="form-control select2" name="estado">
                                                                <option value="">Todos los estados</option>
                                                                <?php foreach ($estados as $est) { ?>
                                                                    <option value="<?= $est['nombre']; ?>"><?= $est['nombre']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- FILTRO: SUCURSAL -->
                                                <div class="col-lg-4 col-md-4 col-sm-6">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading"><strong>Sucursal</strong></div>
                                                        <div class="panel-body">
                                                            <?php
                                                            $sucursales = consultas::get_datos("SELECT * FROM sucursal ORDER BY suc_descri");
                                                            ?>
                                                            <select class="form-control select2" name="sucursal">
                                                                <option value="">Todas las sucursales</option>
                                                                <?php foreach ($sucursales as $s) { ?>
                                                                    <option value="<?= $s['id_sucursal']; ?>"><?= $s['suc_descri']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- FILTROS ADICIONALES ESPECÍFICOS PARA ÓRDENES DE COMPRA -->
                                            <div class="row">
                                                <!-- FILTRO: PROVEEDOR -->
                                                <div class="col-lg-4 col-md-4 col-sm-6">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading"><strong>Proveedor</strong></div>
                                                        <div class="panel-body">
                                                            <?php
                                                            $proveedores = consultas::get_datos("SELECT * FROM proveedor ORDER BY prv_razonsocial");
                                                            ?>
                                                            <select class="form-control select2" name="proveedor">
                                                                <option value="">Todos los proveedores</option>
                                                                <?php foreach ($proveedores as $prov) { ?>
                                                                    <option value="<?= $prov['prv_cod']; ?>"><?= $prov['prv_razonsocial']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BOTÓN IMPRIMIR -->
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary pull-right"
                                                    data-title="Presione para generar el informe" rel="tooltip">
                                                <i class="fa fa-print"></i> Imprimir
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require 'menu/footer_lte.ctp'; ?><!-- FOOTER -->
        </div>
        <?php require 'menu/js_lte.ctp'; ?><!-- JS -->
    </body>
</html>