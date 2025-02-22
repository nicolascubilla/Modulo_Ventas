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
                <!--CONTENEDOR PRINCIPAL-->
                <div class="content">
                    <!--FILA-->
                    <div class="row">
                        <div class=" col-xs-12 col-lg-12 col-md-12">
                            <?php if(!empty($_SESSION['mensaje'])) {?>
                            <div class="alert alert-info" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']=''; ?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i>
                                    <h3 class="box-title">Agregar compras</h3>
                                    <div class="box-tools">
                                        <a  href="compras_index.php" class="btn btn-primary pull-right btn-sm" 
                                            role="button">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>  
                                </div><!--BOX HEADER-->
                                <form action="compras_control.php" method="get" accept-charset="utf-8" 
                                    class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vcom_cod" value="0"/>
                                    <div class="box-body">
                                        
                                        <div class="form-group">
                                            <?php $fecha= consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Fecha:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="date" name="vcom_fecha" class="form-control"
                                                    value="<?php echo $fecha[0]['fecha'];?>" required max="<?php $hoy=date("Y-m-d"); echo $fecha[0]['fecha']?>"/> 
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Condicion:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <select class="form-control select2" name="vtipo_compra" required="" id="tipo_compra" onchange="tipocompra()">
                                                    <option value="CONTADO">CONTADO</option>
                                                    <option value="CREDITO">CREDITO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Proveedor:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="input-group">
                                                    <?php $proveedor= consultas::get_datos("select*from proveedor order by prv_cod");?>
                                                    <select class="form-control select2" name="vprv_cod" required="" id="proveedor" onchange="pedidos()">
                                                        <option value="">Seleccione un proveedor...</option>
                                                        <?php foreach($proveedor as $pro){?>
                                                        <option value="<?php echo $pro['prv_cod']?>">
                                                            <?php echo $pro['prv_razonsocial']?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-btn btn-flat">
                                                        <button class="btn btn-primary" type="button" data-title="presione para agregar un proveedor nuevo"
                                                                data-toggle="modal" data-target="#registrar"><i class="fa fa-plus"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="detalles_pedidos">
                                            </div>
                                        </div>
                                        <div class="form-group tipo" style="display: none">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cant Cuotas:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="number" name="vcan_cuota" class="form-control" 
                                                       min="1" value="1" required="" id="cuota"/> 
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Intervalo Venc.:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="number" name="vcom_plazo" class="form-control" 
                                                       min="0" value="0" required="" id="intervalo"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                               <input type="text" class="form-control" value="<?php echo $_SESSION['sucursal'];?>" disabled/>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Empleado:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="text" class="form-control" value="<?php echo $_SESSION['nombres'];?>" disabled/>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right">
                                            <span class="glyphicon glyphicon-floppy-disk"></span>Registrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--PIE DE PAGINA--> 
                  <!--FORMULARIO MODAL AGREGAR CLIENTES-->
                  <div class="modal fade" id="registrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Agregar clientes</strong></h4>
                              </div>
                              <form action="pedventas_control.php" method="post" accept-charset="UTF-8"
                                  class="form-horizontal">
                                  <input type="hidden" value="1" name="accion"/>
                                  <input type="hidden" value="0" name="vmar_cod"/>
                                  <div class="box-body">
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Descripcion</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="vmar_descri" required="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="box-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-warning">Cerrar</button>
                                      <button type="submit" class="btn btn-success pull-right">Registrar</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $('.modal').on('showm.bs.modal', function() {
              $(this).find('input:text:visible:first').focus();
            });
            
            function tipocompra(){
                //alert($("#tipo_compra").val())
                if($("#tipo_compra").val()=="CONTADO"){
                    $(".tipo").hide();
                    $("#cuota").val(1);
                    $("#cuota").prop("readonly",false);
                    $("#intervalo").val(0);
                    $("#intervalo").prop("readonly",false);
                }else{
                    $(".tipo").show();
                }   
            };
            function pedidos(){
                //alert($("#proveedor").val());
                $.ajax({
                    type    : "GET",
                    url     : "/lp3/compras_pedidos.php?vprv_cod="+$("#proveedor").val(),
                    cache   : false,
                    beforeSend:function(){
                        $("#detalles_pedidos").html('<img src="img/loader.gif" width="20px"/> <strong>Cargando...</strong>');
                    },
                    success :function(data){
                       $("#detalles_pedidos").html(data); 
                    }
                });
            }
        </script>
        
    </body>
</html>
