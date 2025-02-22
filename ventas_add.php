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
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-plus"></i>
                                    <h3 class="box-title">Agregar Venta</h3>
                                    <div class="box-tools">
                                        <a href="ventas_index.php" class="btn btn-primary btn-md" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div>                               
                                <form action="ventas_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vven_cod" value="0">                                    
                                    <div class="box-body">
                                        <div class="form-group">
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Fecha:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="date" name="vven_fecha" 
                                                       class="form-control" value="<?php echo $fecha[0]['fecha'];?>" disabled="">                                                
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Condición:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <select class="form-control select2" name="vtipo_venta" required="" id="tipo_venta" onchange="tipoventa()">
                                                        <option value="CONTADO">CONTADO</option>
                                                        <option value="CREDITO">CREDITO</option>
                                                    </select>                                                
                                            </div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Cliente:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="input-group">
                                                <?php $clientes = consultas::get_datos("select * from clientes order by cli_nombre");?>
                                                    <select class="form-control select2" name="vcli_cod" required="" id="cliente" onchange="pedidos()">
                                                        <option value="">Seleccione un cliente</option>
                                                        <?php foreach ($clientes as $cliente) { ?>
                                                        <option value="<?php echo $cliente['cli_cod'];?>"><?php echo $cliente['cli_nombre']." ".$cliente['cli_apellido'];?></option>
                                                        <?php } ?>
                                                    </select>  
                                                    <span class="input-group-btn btn-flat">
                                                        <button class="btn btn-primary" type="button" data-title="Presione para agregar un cliente" rel="tooltip"
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div> 
                                            </div>
                                            
                                            <div id="detalles_pedidos"></div>                                            
                                        </div>                                                
                                        <div class="form-group tipo" style="display: none">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Cant. Cuotas:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="number" name="vcan_cuota" id="cuotas" class="form-control" required="" min="1" value="1">
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Intervalo Venc.:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="number" name="vven_plazo" id="intervalo" class="form-control" required="" min="0" value="0">                                              
                                            </div>                                            
                                        </div>


                                        <div class="form-group ">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Sucursal:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="text" name="vsucursal" class="form-control" value="<?php echo $_SESSION['sucursal'];?>" disabled="">
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2"> Empleado:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="text" name="vempleado" class="form-control" value="<?php echo $_SESSION['nombres'];?>" disabled="">
                                            </div>                                            
                                        </div>                                        
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Presione para guardar" rel="tooltip">
                                            <i class="fa fa-floppy-o"></i> Registrar
                                        </button>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
            <!-- Inicio Modal Registrar-->
            <div class="modal fade" id="registrar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Marcas</strong></h4>
                        </div>
                        <form action="articulo_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                            <input type="hidden" name="accion" value="4"/>
                            <input type="hidden" name="vart_cod" value="0"/>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Descripción:</label>
                                    <div class="col-lg-8 col-md-8 col-sm-10">
                                        <input type="text" name="vart_descri" class="form-control" required="" autofocus="" placeholder="Ingrese la descripción de la marca"/>                                                
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default" 
                                        data-title="Cerrar ventana" rel="tooltip">
                                    <i class="fa fa-close"></i> Cerrar
                                </button>
                                <button type="submit" class="btn btn-success" data-title="Guardar Marca" rel="tooltip">
                                    <i class="fa fa-floppy-o"></i> Registrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->        
        </div>                  
<?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $(".modal").on("shown.bs.modal", function () {
                $(this).find("input:text:visible:first").focus();
            });
        </script>
        <script>
        function tipoventa(){
            //alert($("#tipo_venta").val())
            if($("#tipo_venta").val()==="CONTADO"){
                $(".tipo").hide();
                $("#cuotas").prop("readonly",false);
                $("#cuotas").val(1);                
                $("#intervalo").prop("readonly",false);
                $("#intervalo").val(0);
            }else{
                $(".tipo").show();
            }
        };
        function pedidos(){
            //alert($("#cliente").val())
            $.ajax({
               type     : "GET",
               url      : "/lp3/ventas_pedidos.php?vcli_cod="+$("#cliente").val(),
               cache    : false,
               beforeSend:function(){
                 $("#detalles_pedidos").html('<img src="img/loading-gif"/><strong>Cargando...</strong>');  
               },
               success:function(data){
                   $("#detalles_pedidos").html(data);  
               }
            });
        }
        </script>
    </body>
</html>


