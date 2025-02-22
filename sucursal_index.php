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
                            <?php if(!empty($_SESSION['mensaje'])){ ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php echo $_SESSION['mensaje']; 
                                    $_SESSION['mensaje'] = "";
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-clipboard"></i>
                                    <h3 class="box-title">Sucursales</h3>
                                    <div class="box-tools">
                                        <a href="sucursal_add.php" class="btn btn-primary btn-sm" data-title="Agregar" 
                                        rel="tooltip" ><i class="fa fa-plus"></i></a>
                                        <a href="sucursal_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="print">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php  
                                                $sucursales = consultas::get_datos("select * from sucursal");
                                                //var_dump($sucursales);
                                                if(!empty($sucursales)){ ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-condensed table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Descripción</th>
                                                                    <th class="text-center">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($sucursales as $sucursal) { ?>
                                                                    <tr>
                                                                        <td data-title="Código"> <?php echo $sucursal['id_sucursal']; ?> </td>
                                                                        <td data-title="Descripción"> <?php echo $sucursal['suc_descri']; ?> </td>
                                                                        <td data-title="Acciones" class="text-center"> 
                                                                            <a href="sucursal_edit.php?vid_sucursal=<?php echo $sucursal['id_sucursal']; ?>" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                            <a href="sucursal_del.php?vid_sucursal=<?php echo $sucursal['id_sucursal']; ?>" class="btn btn-danger btn-sm" data-title="Borrar" rel="tooltip">
                                                                                <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="alert alert-info">
                                                        <i class="fa fa-info"></i>
                                                        No se han registrado sucursales...
                                                    </div>
                                                <?php } 
                                            ?>                                           
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
            $("#mensaje").delay(2000).slideUp(200,function(){
               $(this).alert('close');
            });
        </script>
    </body>
</html>