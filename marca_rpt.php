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
                <!-- AQUI VA EL CONTENIDO DE MARCA -->
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-clipboard"></i>
                                    <h3 class="box-title">Informe de Marcas</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php 
                                            $opcion = "1";
                                            if(isset($_REQUEST['opcion'])){
                                                $opcion = $_REQUEST['opcion'];
                                            }
                                            ?>
                                            <form action="marca_print.php" method="GET" accept-charset="UTF-8" class="form-horizontal">
                                                <input type="hidden" name="opcion" value="<?php echo $opcion;?>">
                                                <div class="box-body">
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <strong>Opciones</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="list-group">
                                                                    <a href="marca_rpt.php?opcion=1" class="list-group-item">Por Codigo</a>
                                                                    <a href="marca_rpt.php?opcion=2" class="list-group-item">Por Descripción</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <strong>Filtros</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php $marcas = consultas::get_datos("select * from marca order by mar_cod");?>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Desde:</label>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                                        <select class="form-control select2" name="vdesde">
                                                                            <?php foreach ($marcas as $marca) { ?>
                                                                            <option value="<?php if($opcion==1){echo $marca['mar_cod'];}else{echo $marca['mar_descri'];};?>"><?php if($opcion==1){echo $marca['mar_cod'];}else{echo $marca['mar_descri'];};?></option>
                                                                             <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Hasta:</label>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                                        <select class="form-control select2" name="vhasta">
                                                                            <?php foreach ($marcas as $marca) { ?>
                                                                            <option value="<?php if($opcion==1){echo $marca['mar_cod'];}else{echo $marca['mar_descri'];};?>"><?php if($opcion==1){echo $marca['mar_cod'];}else{echo $marca['mar_descri'];};?></option>
                                                                             <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary pull-right" 
                                                            data-title="Presione para visualizar el informe" rel="tooltip">
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
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>


