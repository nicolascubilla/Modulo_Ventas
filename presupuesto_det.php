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
                            <div class="alert alert-success" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '';
                                ?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-plus"></i>
                                    <h3 class="box-title">Agregar Detalle Presupuesto</h3>
                                    <div class="box-tools">
                                        <a href="presupuestocliente_index.php" class="btn btn-primary btn-md" 
                                           data-title="Volver" rel="tooltip"> 
                                            <i class="fa fa-arrow-left"></i> </a>                                          
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                           
                                            <?php 
                                            $presupuesto = consultas::get_datos("select * from v_presupuesto_producc_cabecera where pre_cod=".$_REQUEST['vpre_cod']);
                                            //var_dump($marcas);
                                            if(!empty($presupuesto)){ ?>
                                            
                                                <table class="table table-bordered table-striped table-condensed table-hover dt-responsive">
                                    <thead>
                                        <tr>
                                             <th>Cod</th>
                                            <th>fecha</th>
                                            <th>cliente</th>    
                                             <th>Total</th>
                                             <th>Estado</th>
                                         
                                            <th class="text-center">Acciones</th>
                                                                                              

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP foreach ($presupuesto as $presupuesto) {?>
                                        <tr>
                                            <td data-title="Cod:"><?php  echo $presupuesto['pre_cod'];?> </td>
                                             <td data-title="fecha"><?php  echo $presupuesto['fecha'];?> </td>
                                            <td data-title="cliente"><?php  echo $presupuesto['cliente'];?> </td>
                                            <td data-title="Total"><?php echo number_format($presupuesto['total'],0,",",".");?> </td>
                                              <td data-title="Estado"><?php echo ($presupuesto['estado']==="ANULADO")? "<span style='color:red';><strong>".$presupuesto['estado']."</strong></span>":$presupuesto['estado'];?></td>
                                            <td date-title="Aciones" class="text-center">
                                                                <a href="presupuestodetall_print?vpre_cod=<?php echo $presupuesto['pre_cod'];?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip">
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
                                                No se han registrado presupuesto...
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div><!--Fin Cabecera-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php $detallespre = consultas::get_datos("select * from v_detalle_presupuesto where pre_cod=".$presupuesto['pre_cod']);
                                            if(!empty($detallespre)){ ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalles del presupuesto</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Deposito</th>
                                                            <th>Descripción</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                           <!-- <th>Impuesto</th>-->
                                                            <th>Subtotal</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detallespre as $detallespre) { ?>                                                               
                                                        <tr>
                                                            <td data-title="#"><?php echo $detallespre['pre_cod_det'];?></td>
                                                            <td data-title="Deposito"><?php echo $detallespre ['dep_descri'];?></td>
                                                            <td data-title="Descripción"><?php echo $detallespre['art_descri']." ".$detallespre['mar_descri'];?></td>
                                                            <td data-title="Cantidad"><?php echo $detallespre['pre_cant'];?></td>
                                                            <td data-title="Precio"><?php echo number_format($detallespre['pre_precio'],0,",",".");?></td>
                                                            <td data-title="Subtotal"><?php echo number_format($detallespre['subtotal'],0,",",".");?></td>
                                                            <td data-title="Acciones" class="text-center">
    <!-- Botón Editar -->
    <a onclick="editar(<?php echo $detallespre['pre_cod'];?>,<?php echo $detallespre['dep_cod'];?>,<?php echo $detallespre['art_cod'];?>)" 
       class="btn btn-warning btn-md" data-title="Editar" rel="tooltip" 
       data-toggle="modal" data-target="#editar"
       <?php echo ($detallespre['id_estado'] == 3 || $detallespre['id_estado'] == 2) ? 'disabled style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
        <i class="fa fa-edit"></i>                                                                    
    </a>      
    <!-- Botón Borrar -->
    <a onclick="borrar(<?php echo $detallespre['pre_cod'];?>,<?php echo $detallespre['dep_cod'];?>,<?php echo $detallespre['art_cod'];?>,<?php echo "'".$detallespre['art_descri']." ".$detallespre['mar_descri']."'";?>)" 
       class="btn btn-danger btn-md" data-title="Borrar" rel="tooltip" 
       data-toggle="modal" data-target="#borrar"
       <?php echo ($detallespre['id_estado'] == 3 || $detallespre['id_estado'] == 2) ? 'disabled style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
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
                                                    El pedido de presupuesto aún no posee detalles...
                                                </div>                                                
                                            <?php } ?>
                                        </div>
                                    </div><!-- Fin detalles-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="presupuesto_dcontrol.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                                <input type="hidden" name="accion" value="1">
                                                <input type="hidden" name="vpre_cod" value="<?php echo $presupuesto['pre_cod'];?>"/>
                                                <div class="box-body">
    <div class="form-group">
        <label class="control-label col-lg-2 col-sm-2 col-md-2">Deposito:</label>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <?php 
                $id_sucursal = (int)$_SESSION['id_sucursal'];
                $depositos = consultas::get_datos("SELECT * FROM deposito WHERE id_sucursal = $id_sucursal ORDER BY dep_descri");
            ?>
            <select class="form-control select2" name="vdep_cod" required="">
                <option value="">Seleccione un deposito</option>
                <?php foreach ($depositos as $deposito) { ?>
                    <option value="<?php echo $deposito['dep_cod']; ?>"><?php echo $deposito['dep_descri']; ?></option>
                <?php } ?>
            </select>
        </div> <!-- Cierra el div col-lg-6 -->
    </div> <!-- Cierra el div form-group -->


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
                                                            <input type="number" name="vpre_cant" class="form-control" min="1" value="1" required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio:</label>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <input type="number" name="vpre_precio" class="form-control" min="1" value="1" required="" id="vprecio"/>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="box-footer">
                                                <?php if ($detallespre['id_estado'] != 3 && $detallespre['id_estado'] != 2) { ?>
                                                    <button class="btn btn-primary pull-right" type="submit" 
                                                            data-title="Presione para guardar el item" rel="tooltip">
                                                        <i class="fa fa-floppy-o"></i> Guardar
                                                        
                                                    </button>                
                                                    <?php } ?>                                    
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
            function borrar(pre,dep,art,desc){                
                
                $("#si").attr('href', 'presupuesto_dcontrol.php?vpre_cod=' +pre+ '&vdep_cod='+dep+'&vart_cod='+art+'&accion=3');
                $("#confirmacion").html("<span class='glyphicon glyphicon-warning-sign'>\n\
                </span> Desea borrar el articulo <strong>"+desc+"</strong> del pedido de presupuesto?");
                
            };
            function precio(){
                //alert($("#articulo").val())
                var valor = $("#articulo").val().split('_');
                $("#vprecio").val(valor[1]);
            };
            function editar(ped,dep,art){
                //alert(ped+'-'+dep+'-'+art)
                $.ajax({
                    type: "get",
                    url : "/lp3/presupuesto_dedit.php?vpre_cod="+ped+"&vdep_cod="+dep+"&vart_cod="+art,
                    cache:false,
                    beforeSend:function(){
                       $("#detalles").html(' <img src="img/loading-gif"/><strong><h1>Cargando...</h1></strong>');
                    },
                    
                    success:function(data){
                        $("#detalles").html(data)
                    }
                });
            }
        </script>   
       
    </body>
</html>


