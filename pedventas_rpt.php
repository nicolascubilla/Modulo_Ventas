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
                                    <h3 class="box-title">Informe de Pedido de Ventas</h3>
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
                                            <form action="pedventas_print.php" method="GET" accept-charset="UTF-8" class="form-horizontal">
                                                <input type="hidden" name="opcion" value="<?php echo $opcion;?>">
                                                <div class="box-body">
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <strong>Opciones</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="list-group">
                                                                    <a href="pedventas_rpt.php?opcion=1" class="list-group-item">Por Fecha</a>
                                                                    <a href="pedventas_rpt.php?opcion=2" class="list-group-item">Por Cliente</a>
                                                                    <a href="pedventas_rpt.php?opcion=3" class="list-group-item">Por Articulo</a>
                                                                    <a href="pedventas_rpt.php?opcion=4" class="list-group-item">Por Empleado</a>
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
                                                                
                                                                <?php switch ($opcion) {
                                                                        case 1: //por fechas 
                                                                        $fecha = consultas::get_datos("select current_date as fecha");    
                                                                            ?>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-sm-2 col-md-2">Desde:</label>
                                                                    <div class="col-lg-6 col-sm-6 col-md-6">
                                                                        <input type="date" class="form-control" name="vdesde" value="<?php echo $fecha[0]['fecha'];?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-sm-2 col-md-2">Hasta:</label>
                                                                    <div class="col-lg-6 col-sm-6 col-md-6">
                                                                        <input type="date" class="form-control" name="vhasta" value="<?php echo $fecha[0]['fecha'];?>">
                                                                    </div>
                                                                </div>                                                                

                                                                <?php  break;
                                                                        case 2: //por cliente 
                                                                            $clientes = consultas::get_datos("select * from clientes where cli_cod in(select cli_cod "
                                                                                    . "from pedido_cabventa where id_sucursal =".$_SESSION['id_sucursal']." )"); ?>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-sm-2 col-md-2">Clientes:</label>
                                                                    <div class="col-lg-8 col-sm-8 col-md-8">
                                                                        <select class="form-control select2" name="vcliente">
                                                                            <option value="">Seleccione un cliente</option>
                                                                            <?php foreach ($clientes as $cliente) { ?>
                                                                                 <option value="<?php echo $cliente['cli_cod'];?>">
                                                                                     <?php echo "(".$cliente['cli_ci'].") ".$cliente['cli_nombre']." ".$cliente['cli_apellido'];?></option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>                                                                    
                                                                </div>
                                                                <?php   break;
                                                                        case 3: //por articulo 
                                                                            $articulos = consultas::get_datos("select * from v_articulo where art_cod in(select a.art_cod "
                                                                                    . "from detalle_pedventa a "
                                                                                    . "join pedido_cabventa b on a.ped_cod =b.ped_cod "
                                                                                    . "where b.id_sucursal =".$_SESSION['id_sucursal']." )"); ?>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-sm-2 col-md-2">Articulos:</label>
                                                                    <div class="col-lg-8 col-sm-8 col-md-8">
                                                                        <select class="form-control select2" name="varticulo">
                                                                            <option value="">Seleccione un articulo</option>
                                                                            <?php foreach ($articulos as $articulo) { ?>
                                                                                 <option value="<?php echo $articulo['art_cod'];?>">
                                                                                     <?php echo $articulo['art_descri']." ".$articulo['mar_descri'];?></option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>                                                                    
                                                                </div>
                                                                <?php   break;  
                                                                        case 4: //por empleado 
                                                                            $empleados = consultas::get_datos("select * from empleado where emp_cod in(select emp_cod "
                                                                                    . "from pedido_cabventa where id_sucursal =".$_SESSION['id_sucursal']." )"); ?>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-2 col-sm-2 col-md-2">Empleados:</label>
                                                                    <div class="col-lg-8 col-sm-8 col-md-8">
                                                                        <select class="form-control select2" name="vempleado">
                                                                            <option value="">Seleccione un empleado</option>
                                                                            <?php foreach ($empleados as $empleado) { ?>
                                                                                 <option value="<?php echo $empleado['emp_cod'];?>">
                                                                                     <?php echo $empleado['emp_nombre']." ".$empleado['emp_apellido'];?></option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>                                                                    
                                                                </div>
                                                                <?php   break;                                                                
                                                                }                                                                
                                                                ?>
                                                                                                      
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


