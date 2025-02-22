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
                                    <i class="fa fa-plus"></i>
                                    <h3 class="box-title">Agregar Detalle Ventas</h3>
                                    <div class="box-tools">
                                        <a href="ventas_index.php" class="btn btn-primary btn-md" 
                                           data-title="Volver" rel="tooltip"> 
                                            <i class="fa fa-arrow-left"></i> </a>                                          
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                           
                                            <?php 
                                            $ventas = consultas::get_datos("select * from v_ventas where ven_cod=".$_REQUEST['vven_cod']);
                                            //var_dump($ventas);
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
                                                                <a href="ventas_print?vven_cod=<?php echo $venta['ven_cod'];?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip">
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
                                                No se han encontrado registro de esa venta...
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div><!--Fin Cabecera-->
                                    <!-- SECCION PEDIDO VENTA-->
                                    <?php if($ventas[0]['ped_cod']!="0"){ ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php $pdetalles = consultas::get_datos("select * from v_detalle_pedventa "
                                                    . "where ped_cod=".$ventas[0]['ped_cod']
                                                    ." and art_cod not in(select art_cod from detalle_ventas where ven_cod=".$ventas[0]['ven_cod'].")");
                                            if(!empty($pdetalles)){ ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalles del Pedido N° <?php echo $ventas[0]['ped_cod'];?></h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Descripción</th>
                                                            <th>Deposito</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                            <th>Impuesto</th>
                                                            <th>Subtotal</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($pdetalles as $pdetalle) { ?>                                                               
                                                        <tr>
                                                            <td data-title="Descripción"><?php echo $pdetalle['art_descri']." ".$pdetalle['mar_descri'];?></td>
                                                            <td data-title="Deposito"><?php echo $pdetalle['dep_descri'];?></td>
                                                            <td data-title="Cantidad"><?php echo $pdetalle['ped_cant'];?></td>
                                                            <td data-title="Precio"><?php echo number_format($pdetalle['ped_precio'],0,",",".");?></td>
                                                            <td data-title="Impuesto"><?php echo $pdetalle['tipo_descri'];?></td>
                                                            <td data-title="Subtotal"><?php echo number_format($pdetalle['subtotal'],0,",",".");?></td>
                                                            <td data-title= "Acciones" class="text-center">
                                                                <a onclick="add(<?php echo $pdetalle['ped_cod'];?>,<?php echo $pdetalle['dep_cod'];?>,<?php echo $pdetalle['art_cod'];?>,<?php echo $ventas[0]['ven_cod'];?>)" class="btn btn-success btn-md" 
                                                                   data-title="Agregar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                                                    <i class="fa fa-plus"></i>                                                                    
                                                                </a>                                                                                                                                
                                                            </td>
                                                        </tr>
                                                         <?php } ?>
                                                    </tbody>
                                                </table>                                                
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div><!-- Fin detalles-->
                                    <?php } ?>
                                    <!-- FIN SECCION PEDIDO VENTA-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php $detalles = consultas::get_datos("select * from v_detalle_ventas where ven_cod=".$ventas[0]['ven_cod']);
                                            if(!empty($detalles)){ ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalles de la Venta</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                            <th>Impuesto</th>
                                                            <th>Subtotal</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $detalle) { ?>                                                               
                                                        <tr>
                                                            <td data-title="#"><?php echo $detalle['art_cod'];?></td>
                                                            <td data-title="Descripción"><?php echo $detalle['art_descri']." ".$detalle['mar_descri'];?></td>
                                                            <td data-title="Cantidad"><?php echo $detalle['ven_cant'];?></td>
                                                            <td data-title="Precio"><?php echo number_format($detalle['ven_precio'],0,",",".");?></td>
                                                            <td data-title="Impuesto"><?php echo $detalle['tipo_descri'];?></td>
                                                            <td data-title="Subtotal"><?php echo number_format($detalle['subtotal'],0,",",".");?></td>
                                                            <td data-title= "Acciones" class="text-center">
                                                                <a onclick="editar(<?php echo $detalle['ven_cod'];?>,<?php echo $detalle['dep_cod'];?>,<?php echo $detalle['art_cod'];?>)" class="btn btn-warning btn-md" 
                                                                   data-title="Editar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                                                    <i class="fa fa-edit"></i>                                                                    
                                                                </a>
                                                                <a onclick="borrar(<?php echo $detalle['ven_cod'];?>,<?php echo $detalle['dep_cod'];?>,<?php echo $detalle['art_cod'];?>,<?php echo "'".$detalle['art_descri']." ".$detalle['mar_descri']."'";?>)" class="btn btn-danger btn-md" 
                                                                   data-title="Borrar" rel="tooltip" data-toggle="modal" data-target="#borrar">
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
                                                    <span class="glyphicon glyphicon-info-sign"></span>
                                                    La venta aún no posee detalles...
                                                </div>                                                
                                            <?php } ?>
                                        </div>
                                    </div><!-- Fin detalles-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="ventas_dcontrol.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                                <input type="hidden" name="accion" value="1">
                                                <input type="hidden" name="vven_cod" value="<?php echo $ventas[0]['ven_cod'];?>"/>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-2 col-md-2">Deposito:</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <?php $depositos = consultas::get_datos("select * from deposito order by dep_descri");?>
                                                                <select class="form-control select2" name="vdep_cod" required="">
                                                                    <option value="">Seleccione un deposito</option>
                                                                    <?php foreach ($depositos as $deposito) { ?>
                                                                    <option value="<?php echo $deposito['dep_cod'];?>"><?php echo $deposito['dep_descri'];?></option>
                                                                    <?php } ?>
                                                                </select>                                       
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-2 col-md-2">Articulo:</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <?php $articulos = consultas::get_datos("select * from v_articulo order by art_descri");?>
                                                            <select class="form-control select2" name="vart_cod" required="" onchange="precio()" id="articulo">
                                                                    <option value="">Seleccione un articulo</option>
                                                                    <?php foreach ($articulos as $articulo) { ?>
                                                                    <option value="<?php echo $articulo['art_cod']."_".$articulo['art_preciov'];?>"><?php echo $articulo['art_descri']." ".$articulo['mar_descri'];?></option>
                                                                    <?php } ?>
                                                                </select>                                       
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-2 col-md-2">Cantidad:</label>
                                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                                            <input type="number" name="vven_cant" class="form-control" min="1" value="1" required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio:</label>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <input type="number" name="vven_precio" class="form-control" min="1" value="1" required="" id="vprecio"/>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="box-footer">
                                                    <button class="btn btn-primary pull-right" type="submit" 
                                                            data-title="Presione para guardar el item" rel="tooltip">
                                                        <i class="fa fa-floppy-o"></i> Guardar
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
            <!-- MODAL EDITAR-->
            <div class="modal fade" id="editar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" id="detalles">
                        
                    </div>
                </div>
            </div>
            <!-- FIN MODAL EDITAR-->
                  <!-- Inicio Modal Anular-->
            <div class="modal fade" id="borrar" role="dialog">
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
            function borrar(ven,dep,art,desc){                
                
                $("#si").attr('href', 'ventas_dcontrol.php?vven_cod=' + ven + '&vdep_cod='+dep+'&vart_cod='+art+'&accion=3');
                $("#confirmacion").html("<span class='glyphicon glyphicon-warning-sign'>\n\
                </span> Desea borrar el articulo <strong>"+desc+"</strong> de la venta?");
                
            };
            function precio(){
                //alert($("#articulo").val())
                var valor = $("#articulo").val().split('_');
                $("#vprecio").val(valor[1]);
            };
            function editar(ven,dep,art){
                //alert(ped+'-'+dep+'-'+art)
                $.ajax({
                    type: "get",
                    url : "/lp3/ventas_dedit.php?vven_cod="+ven+"&vdep_cod="+dep+"&vart_cod="+art,
                    cache:false,
                    beforeSend:function(){
                        $("#detalles").html('<img src="img/ajax-loader.gif"/><strong>Cargando...</strong>');
                    },
                    success:function(data){
                        $("#detalles").html(data)
                    }
                });
            };
            function add(ped,dep,art,ven){
                //alert(ped+'-'+dep+'-'+art)
                $.ajax({
                    type: "get",
                    url : "/lp3/ventas_dadd.php?vped_cod="+ped+"&vdep_cod="+dep+"&vart_cod="+art+"&vven_cod="+ven,
                    cache:false,
                    beforeSend:function(){
                        $("#detalles").html('<img src="img/ajax-loader.gif"/><strong>Cargando...</strong>');
                    },
                    success:function(data){
                        $("#detalles").html(data)
                    }
                });
            }            
        </script>        
    </body>
</html>


