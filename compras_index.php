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
                                    <i class="fa fa-money"></i>
                                    <h3 class="box-title">Compras</h3>
                                    <div class="box-tools">
                                        <a  href="compras_add.php" class="btn btn-primary pull-right btn-sm" role="button">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>  
                                </div><!--BOX HEADER-->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 col-md-12">
                                            <?php 
                                            //CONSULTA A LA TABLA MARCA
                                            $compras= consultas::get_datos("select*from v_compra where com_fecha::date = current_date and id_sucursal=".$_SESSION['id_sucursal']." order by com_cod");
                                            if (!empty($compras)) { ?>
                                            <div class="table-responsive">
                                                <table class=" table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Proveedor</th>
                                                            <th>Condicion</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                         foreach ($compras as $compra) { ?>
                                                        <tr>
                                                            <td data-title='Codigo'> <?php echo $compra['com_cod']?> </td>
                                                            <td data-title='Fecha'> <?php echo $compra['com_fecha']?> </td>
                                                            <td data-title='Cliente'> <?php echo $compra['prv_razonsocial']?> </td>
                                                            <td data-title='Total'> <?php echo $compra['tipo_compra']?> </td>
                                                            <td data-title='Total'> <?php echo $compra['com_total']?> </td>
                                                            <td data-title='Estado'> <?php echo $compra['com_estado']?> </td>
                                                            <td data-title='acciones'class="text-center">
                                                                <?php if($compra['com_estado']=='PENDIENTE') { ?>
                                                                <a onclick="confirmar(<?php echo "'".$compra['com_cod']."_".$compra['prv_razonsocial'].
                                                                        "_".$compra['com_fecha']."'"?>)"
                                                                    class="btn btn-info btn-sm" role='button'
                                                                   data-title='confirmar' rel="tooltip" data-placement='top'
                                                                   data-toggle="modal" data-target="#confirmar">
                                                                    <span class="glyphicon glyphicon-check"></span>
                                                                </a>
                                                                <a href="compras_det.php?vcom_cod=<?php echo $compra['com_cod']?>" 
                                                                   class="btn btn-success btn-sm" role='button'
                                                                   data-title='detalles' rel="tooltip" data-placement='top'>
                                                                    <span class="glyphicon glyphicon-list"></span>
                                                                </a>
                                                                <?php } ?>
                                                                <?php if($compra['com_estado']=='PENDIENTE'||$compra['com_estado']=='CONFIRMADO') { ?>
                                                                <a onclick="anular(<?php echo "'".$compra['com_cod']."_".$compra['prv_razonsocial'].
                                                                        "_".$compra['com_fecha']."'"?>)"
                                                                    class="btn btn-danger btn-sm" role='button'
                                                                   data-title='Anular' rel="tooltip" data-placement='top'
                                                                   data-toggle="modal" data-target="#anular">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                                <?php } ?>
                                                                <a href="compras_print.php?vcom_cod=<?php echo $compra['com_cod']?>" class="btn btn-default" role="button" target="print"
                                                                   data-title="Imprimir" rel="tooltip" data-placement="top">
                                                                    <i class="fa fa-print"></i></a>
                                                                   
                                                            </td>
                                                        </tr>
                                                         <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado compras...
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
                  <?php require 'menu/footer_lte.ctp'; ?><!--PIE DE PAGINA--> 
                   <!--FORMULARIO MODAL BORRAR-->
                  <div class="modal fade" id="anular" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                      aria-label="close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h4 class="modal-title"><strong>Atenci&oacute;n!!!</strong></h4>
                              </div>
                              <div class="modal-body">
                                  <div class="alert alert-warning" id="confirmacion"></div>
                              </div>
                              <div class="modal-footer">
                                  <a id="si" role="button" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span>Si</a>
                                      <button class="btn btn-default" data-dismiss="modal">
                                          <i class="fa fa-close"></i>No</button>
                              </div>
                          </div>
                      </div>
                  </div>
                   <!--FORMULARIO MODAL CONFIRMAR-->
                  <div class="modal fade" id="confirmar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                      aria-label="close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h4 class="modal-title"><strong>Atenci&oacute;n!!!</strong></h4>
                              </div>
                              <div class="modal-body">
                                  <div class="alert alert-success" id="confirmacionc"></div>
                              </div>
                              <div class="modal-footer">
                                  <a id="sic" role="button" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span>Si</a>
                                      <button class="btn btn-default" data-dismiss="modal">
                                          <i class="fa fa-close"></i>No</button>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200,function(){
                $(this).alert('close');
            });
           function anular(datos){
                var dat= datos.split("_");
                $("#si").attr('href','compras_control.php?vcom_cod='+dat[0]+'&vcom_fecha='+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
                   Desea anular la compra N° <i><strong> '+dat[0]+'</strong></i> de fecha <i><strong>'+dat[2]
                +' y proveedor '+dat[1]+'</strong></i>'+'?');

            }
            function confirmar(datos){
                var dat= datos.split("_");
                $("#sic").attr('href','compras_control.php?vcom_cod='+dat[0]+'&vcom_fecha='+dat[2]+'&accion=2');
                $('#confirmacionc').html('<span class="glyphicon glyphicon-question-sign"></span>\n\
                   Desea confirmar la compra N° <i><strong> '+dat[0]+'</strong></i> de fecha <i><strong>'+dat[2]
                +' y proveedor '+dat[1]+'</strong></i>'+'?');

            }
        </script>
        <script>
            $('.modal').on('showm.bs.modal', function() {
              $(this).find('input:text:visible:first').focus();
            });
        </script>
        
    </body>
</html>