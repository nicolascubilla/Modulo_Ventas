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
                        <div class=" col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="fa fa-edit"></i>
                                                    
                                    <h3 class="box-title">Editar Marca</h3>
                                    <div class="box-tools">
                                        <a href="marca.index.php" class="btn btn-primary btn-md"
                                           data-title="volver" rel="tooltip"><i class="fa fa-arrow-left"></i></a>
                                            </div>
                                </div>
                                <form action="marca_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <?php $marcas = consultas::get_datos("select * from marca where mar_cod=".$_REQUEST['vmar_cod']); 
                                  //var_dump($marcas);
                                    ?>
                                    <div class="box-body">
                                        <input type="hidden" name="accion" value="2">
                                        <input type="hidden" name="vmar_cod" value="<?php echo $marcas[0]['mar_cod'];?>">
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-sm-2 col-md-2">Descripcion:</label>
                                            <div class="col-lg-8 col-sm-6 col-md-6">
                                                <input type="text" name="vmar_descri" class="form-control" 
                                                       required="" autofocus="" value="<?php echo $marcas[0]['mar_descri'];?>">
                                                </div>
                                            </div>
                                         </div>
                                    <div class="box-footer">
                                         <button type="submit" class="btn btn-warning pull-right" data-title="precione para Actualizar" rel="tooltip">
                                                <i class=" fa fa-edit"></i>  Actualizar
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

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                    

