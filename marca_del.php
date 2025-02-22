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
                            <div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-trash"></i>
                                    <h3 class="box-title">Borrar Marca</h3>
                                    <div class="box-tools">
                                        <a href="marca.index.php" class="btn btn-primary btn-md" 
                                           data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <form action="marca_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                    <?php $marcas = consultas::get_datos("select * from marca where mar_cod =".$_GET['vmar_cod']);?>                                    
                                    <input type="hidden" name="accion" value="3">
                                    <input type="hidden" name="vmar_cod" value="<?php echo $marcas[0]['mar_cod'];?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Descripción:</label>
                                            <div class="col-lg-8 col-sm-6 col-md-6">
                                                <input type="text" name="vmar_descri" class="form-control" 
                                                       value="<?php echo $marcas[0]['mar_descri'];?>" readonly=""/>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-danger pull-right" data-title="Presione para borrar la marca" rel="tooltip">
                                            <i class="fa fa-trash"> Borrar</i>
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


