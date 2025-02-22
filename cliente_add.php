<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>LP3</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp';?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-plus"></i>
                                    <h3 class="box-title"> Agregar Cliente</h3>
                                    <div class="box-tools">
                                        <a href="cliente_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <form action="cliente_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                    <div class="box-body">
                                        <input type="hidden" name="accion" value="1" />
                                        <input type="hidden" name="vcli_cod" value="0" />
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-xs-2">C.I.:</label>
                                            <div class="col-lg-6 col-md-4 col-xs-4">
                                                <input type="number" name="vcli_ci" class="form-control" required="" minlength="3" autofocus="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-xs-2">Nombre:</label>
                                            <div class="col-lg-8 col-md-6 col-xs-6">
                                                <input type="text" name="vcli_nombre" class="form-control" required="" minlength="3" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-xs-2">Apellido:</label>
                                            <div class="col-lg-8 col-md-6 col-xs-6">
                                                <input type="text" name="vcli_apellido" class="form-control" required="" minlength="3" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-xs-2">Teléfono:</label>
                                            <div class="col-lg-6 col-md-4 col-xs-4">
                                                <input type="text" name="vcli_telefono" class="form-control" required="" minlength="3" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-xs-2">Dirección:</label>
                                            <div class="col-lg-8 col-md-6 col-xs-6">
                                                <input type="text" name="vcli_direcc" class="form-control" required="" minlength="3" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Presione para guardar" rel="tooltip">
                                            <i class="fa fa-floppy-o"> Registrar</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>