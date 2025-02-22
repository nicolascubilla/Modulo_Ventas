<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>Marca</title>
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
<!--Aqui va el contenido de Marca-->
<div class="content">
    <!--fila-->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <?php if (!empty($_SESSION ['mensaje'])){?>;
            <div class="alert alert-danger" role="alert"id="mensaje">
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                <?php echo $_SESSION ['mensaje'];
                $_SESSION['mensaje']= '';
                ?>
                
            </div>  
           <?php  } ?>
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Marcas</h3>
                    <div class="box-tools">
                        <a href="marca_add.php" class="btn btn-primary btn-md"
                           data-title="Agregar" rel="tooltip">
                            <i class="fa fa-plus"></i></a>
                            <a href="marca_print.php" class="btn btn-default btn-md"
                           data-title="Imprimir" rel="tooltip">
                            <i class="fa fa-print"></i></a>
                        
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <?php
                            $marcas = consultas::get_datos('select * from marca');
                            //var_dump($marcas);
                            if (!empty($marcas)){?>
                           
                                <table class="table table-bordered table-striped table-condensed table-hover dt-responsive">
                                    <thead>
                                        <tr>
                                            <th>CODIGO</th>
                                            <th>DESCRIPCION</th>
                                            <th class="text-center">Acciones</th>
                                                                                              

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP foreach ($marcas as $marca) {?>
                                        <tr>
                                            <td data-title="Codigo"><?php  echo $marca['mar_cod'];?> </td>
                                            <td data-title="Descripcion"><?php  echo $marca['mar_descri'];?> </td>
                                            <td date-title="Aciones" class="text-center">
                                                <a href="marca_edit.php?vmar_cod=<?php echo $marca['mar_cod'];?>" class="btn btn-warning btn-md" data-title="editar"rel="tooltip">
                                                <i class="fa fa-edit"></i>
                                                </a>
                                                 <a href="marca_del.php?vmar_cod=<?php echo $marca['mar_cod'];?>" class="btn btn-danger btn-md" data-title="Borrar"rel="tooltip">
                                                <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                            
                                        <?php }?>
                                    </tbody>
                                </table>
                           
                          <?php } else { ?>
                            <div class="alert alert-info flat">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                No se han registrado marcas...
                            </div>
                                
                            <?php } ?>
                            
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
        <script>
          $("#mensaje").delay(4000).slideUp(200, function(){
          $(this).alert('close');    
          });
        </script>
    </body>
</html>

