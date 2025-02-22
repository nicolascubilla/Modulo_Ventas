<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <title>LP3</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-plus"></i>
                                    <h3 class="box-title">Agregar Página</h3>
                                    <div class="box-tools">
                                        <a href="pagina_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div>                               
                                <form action="pagina_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vpag_cod" value="0">                                    
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Dirección:</label>
                                            <div class="col-lg-8 col-md-6 col-sm-6">
                                                <input type="text" name="vpag_direc" class="form-control" required="" minlength="3" autofocus=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Nombre:</label>
                                            <div class="col-lg-8 col-md-6 col-sm-6">
                                                <input type="text" name="vpag_nombre" class="form-control" required="" minlength="3" autofocus=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Módulo:</label>
                                            <div class="col-lg-6 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <?php $modulos = consultas::get_datos("select * from modulos order by mod_nombre"); ?>
                                                    <select class="form-control select2" name="vmod_cod" required="">
                                                        <?php foreach ($modulos as $modulo) { ?>
                                                        <option value="<?php echo $modulo['mod_cod']; ?>"><?php echo $modulo['mod_nombre']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Presione para guardar" rel="tooltip">
                                            <i class="fa fa-floppy-o"></i> Registrar
                                        </button>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
            <!-- Inicio Modal Registrar-->
            <div class="modal fade" id="registrar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Módulos</strong></h4>
                        </div>
                        <form action="pagina_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                            <input type="hidden" name="accion" value="4"/>
                            <input type="hidden" name="vpag_cod" value="0"/>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Nombre:</label>
                                    <div class="col-lg-8 col-md-8 col-sm-10">
                                        <input type="text" name="vpag_nombre" class="form-control" required="" autofocus="" placeholder="Ingrese el nombre del módulo"/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default" 
                                        data-title="Cerrar ventana" rel="tooltip">
                                    <i class="fa fa-close"></i> Cerrar
                                </button>
                                <button type="submit" class="btn btn-success" data-title="Guardar Módulo" rel="tooltip">
                                    <i class="fa fa-floppy-o"></i> Registrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->
        </div>                  
    <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $(".modal").on("shown.bs.modal", function () {
                $(this).find("input:text:visible:first").focus();
            });
        </script> 
    </body>
</html>


