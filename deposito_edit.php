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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-edit"></i>
                                    <h3 class="box-title">Editar Deposito</h3>
                                    <div class="box-tools">
                                        <a href="deposito_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> Volver</a>
                                    </div>
                                </div>
                                <form action="deposito_control.php" method="post" accept-charset="utf-8" class="form-horizontal">                                                                        
                                    <?php $resultado = consultas::get_datos("select * from v_deposito where dep_cod =".$_GET['vdep_cod']);?>
                                    <input type="hidden" name="accion" value="2"/>
                                    <input type="hidden" name="vdep_cod" value="<?php echo $resultado[0]['dep_cod'];?>"/>                                
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Descripción:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="text" class="form-control" name="vdep_descri" required="" autofocus=""
                                                       value="<?php echo $resultado[0]['dep_descri'];?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $sucursales = consultas::get_datos("select * from sucursal order by id_sucursal=".$resultado[0]['id_sucursal']." desc"); ?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vid_sucursal" required="">                                                        
                                                        <?php foreach ($sucursales as $sucursal) { ?>
                                                        <option value="<?php echo $sucursal['id_sucursal'];?>"><?php echo $sucursal['suc_descri'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                                       
                                    </div>  
                                    <div class="box-footer">                                     
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                            <i class="fa fa-floppy-o"></i> Registrar</button>
                                            <a href="deposito_index.php" class="btn btn-danger btn-sm" data-title="Cancelar" rel="tooltip">
                                            <i class="fa fa-remove"></i> Cancelar</a>
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
                                <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Sucursales</strong></h4>
                            </div>
                            <form action="deposito_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="accion" value="4"/>
                                <input type="hidden" name="vdep_cod" value="0"/>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-lg-2 col-md-2 col-sm-2">Descripción:</label>
                                        <div class="col-lg-8 col-md-8 col-sm-10">
                                            <input type="text" name="vdep_descri" class="form-control" required="" autofocus="" placeholder="Ingrese la descripción de la sucursal"/>                                                
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" data-dismiss="modal" class="btn btn-default" 
                                            data-title="Cerrar ventana" rel="tooltip">
                                        <i class="fa fa-close"></i> Cerrar
                                    </button>
                                    <button type="submit" class="btn btn-success" data-title="Guardar Sucursal" rel="tooltip">
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
    </body>
</html>


