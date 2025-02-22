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
                            <?php if(!empty($_SESSION['mensaje'])){ ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '';
                                ?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-money"></i>
                                    <h3 class="box-title">Ventas</h3>
                                    <div class="box-tools">
                                        <a href="ventas_add.php" class="btn btn-primary btn-md" 
                                           data-title="Agregar" rel="tooltip"> 
                                            <i class="fa fa-plus"></i> </a>                                          
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="ventas_index.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" name="buscar" class="form-control" autofocus=""
                                                                       placeholder="Ingrese descripción a buscar"/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary" 
                                                                            data-title="Presione para buscar" rel="tooltip">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </span>                                                                
                                                            </div>                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>                                            
                                            <?php 
                                            $ventas = consultas::get_datos("select * from v_ventas where ven_fecha::date=current_date and id_sucursal = ".$_SESSION['id_sucursal']." order by ven_cod desc");
                                            //var_dump($marcas);
                                            if(!empty($ventas)){ ?>
                                            
                                                <table class="table table-striped table-condensed table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Cliente</th>
                                                            <th>Condición</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($ventas as $venta) { ?>                                                               
                                                        <tr>
                                                            <td data-title="#"><?php echo $venta['ven_cod'];?></td>
                                                            <td data-title="Fecha"><?php echo $venta['ven_fecha'];?></td>
                                                            <td data-title="Cliente"><?php echo $venta['cliente'];?></td>
                                                            <td data-title="Condición"><?php echo $venta['tipo_venta'];?></td>
                                                            <td data-title="Total"><?php echo number_format($venta['ven_total'],0,",",".");?></td>
                                                            <td data-title="Estado"><?php echo ($venta['ven_estado']==="ANULADO")? "<span style='color:red';><strong>".$venta['ven_estado']."</strong></span>":$venta['ven_estado'];?></td>
                                                            <td data-title= "Acciones" class="text-center">
                                                                <?php if($venta['ven_estado']=="PENDIENTE"){ ?>
                                                                <a onclick="confirmar(<?php echo "'".$venta['ven_cod']."_".$venta['cliente']."'";?>)" class="btn btn-success btn-md" 
                                                                   data-title="Confirmar" rel="tooltip" data-toggle="modal" data-target="#confirmar">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                                <a href="ventas_det.php?vven_cod=<?php echo $venta['ven_cod'];?>" class="btn btn-primary btn-md" data-title="Detalles" rel="tooltip">
                                                                    <i class="fa fa-list"></i>                                                                    
                                                                </a> 
                                                                <?php } ?>
                                                                <?php if($venta['ven_estado']=="PENDIENTE" || $venta['ven_estado']=="CONFIRMADO"){ ?>
                                                                <a onclick="anular(<?php echo "'".$venta['ven_cod']."_".$venta['cliente']."'"?>)" class="btn btn-danger btn-md" 
                                                                   data-title="Anular" rel="tooltip" data-toggle = "modal" data-target="#anular">
                                                                    <i class="fa fa-remove"></i></a>
   
                                                                <?php } ?>
                                                                <a href="ventas_print?vven_cod=<?php echo $venta['ven_cod'];?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                                                    <i class="fa fa-print"></i>                                                                    
                                                                </a>                                                                
                                                            </td>
                                                        </tr>
                                                         <?php } ?>
                                                    </tbody>
                                                </table>
                   
                                            <?php }else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado ventas...
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
            <!-- Inicio Modal Confirmar-->
            <div class="modal fade" id="confirmar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title custom-align"> <strong>Atención!!!</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success" id="confirmacionc">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <a id="sic" role="buttom" class="btn btn-primary">
                                <i class="fa fa-check"></i> Si
                            </a>
                            <button type="reset" data-dismiss="modal" class="btn btn-default" 
                                    data-title="Cancelar" rel="tooltip">
                                <i class="fa fa-close"></i> No
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->  
                  <!-- Inicio Modal Anular-->
            <div class="modal fade" id="anular" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title custom-align"> <strong>Atención!!!</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="confirmacion">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <a id="si" role="buttom" class="btn btn-primary">
                                <i class="fa fa-check"></i> Si
                            </a>
                            <button type="reset" data-dismiss="modal" class="btn btn-default" 
                                    data-title="Cancelar" rel="tooltip">
                                <i class="fa fa-close"></i> No
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->                  
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
        $("#mensaje").delay(4000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
        <script>
            function anular(datos){
                var dat = datos.split("_");
                $("#si").attr('href', 'ventas_control.php?vven_cod=' + dat[0] + '&accion=3');
                $("#confirmacion").html("<span class='glyphicon glyphicon-warning-sign'>\n\
                </span> Desea anular la Venta N° <strong>" 
                + dat[0] + "</strong> del cliente <strong>" + dat[1] + "</strong>?");
            };
            function confirmar(datos){
                var dat = datos.split("_");
                $("#sic").attr('href', 'ventas_control.php?vven_cod=' + dat[0] + '&accion=2');
                $("#confirmacionc").html("<span class='glyphicon glyphicon-question-sign'>\n\
                </span> Desea confirmar la Venta N° <strong>" 
                + dat[0] + "</strong> del cliente <strong>" + dat[1] + "</strong>?");                
            }
        </script>        
    </body>
</html>


