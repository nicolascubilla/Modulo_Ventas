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
                                    <h3 class="box-title">Editar articulos</h3>
                                    <div class="box-tools">
                                        <a href="articulos_index.php" class="btn btn-primary pull-right btn-sm">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>  
                                </div><!--BOX HEADER-->
                                <form action="articulos_control.php" method="post" acept-charset='UTF-8' class="form-horizontal">
                                    <?php $articulos=consultas::get_datos("select * from v_articulo where art_cod=".$_REQUEST['vart_cod']);?>
                                    <input type="hidden" name="accion" value="2">
                                    <input type="hidden" name="vart_cod" value="<?php echo $_REQUEST['vart_cod']?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-lg-2 col-md-2 col-sm-2 control-label">Cod. barra</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <input type='text' class='form-control' autofocus="" name='vart_codbarra' 
                                                       value="<?php echo $articulos[0]['art_codbarra']?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Marca</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="input-group">
                                                    <?php $marca= consultas::get_datos("select*from marca order by mar_cod=".$articulos[0]['mar_cod']." desc")?>
                                                    <select class="form-control select2" name="vmar_cod" required="" autofocus="">
                                                    <?php foreach($marca as $mar){ ?>
                                                        <option value="<?php echo $mar['mar_cod']?>">
                                                        <?php echo $mar['mar_descri']?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary btn-flat" type="button"
                                                            data-toggle="modal" data-target="#registrar">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-md-2 col-sm-2 control-label">Descripcion</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <input type='text' class='form-control' name='vart_descri' required minilength="3"
                                                       value="<?php echo $articulos[0]['art_descri']?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-md-2 col-sm-2 control-label">Precio compra</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <input type='number' class='form-control' name='vart_precioc' 
                                                       required autofocus min="0" value="<?php echo $articulos[0]['art_precioc']?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-md-2 col-sm-2 control-label">Precio venta</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <input type='number' class='form-control' name='vart_preciov' 
                                                       required autofocus min="0" value="<?php echo $articulos[0]['art_preciov']?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Impuesto</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="input-group">
                                                    <?php $tipos= consultas::get_datos("select*from tipo_impuesto order by tipo_cod=".$articulos[0]['tipo_cod']." desc")?>
                                                    <select class="form-control select2"  name="vtipo_cod" required="">
                                                    <?php foreach($tipos as $tipo){ ?>
                                                    <option value="<?php echo $tipo['tipo_cod']?>">
                                                        <?php echo $tipo['tipo_descri']?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary btn-flat" type="button"
                                                            data-toggle="modal" data-target="#registrartipo">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right">Registrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
                  <!--FORMULARIO MODAL AGREGAR MARCA-->
                  <div class="modal fade" id="registrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Agregar marcas</strong></h4>
                              </div>
                              <form action="articulos_control.php" method="post" accept-charset="UTF-8"
                                  class="form-horizontal">
                                  <input type="hidden" value="4" name="accion"/>
                                  <input type="hidden" value="0" name="vart_cod"/>
                                  <div class="box-body">
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Descripcion</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="vart_descri" required="">
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
                  <!--FORMULARIO MODAL AGREGAR TIPO IMPUESTO-->
                  <div class="modal fade" id="registrartipo" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Agregar Impuestos</strong></h4>
                              </div>
                              <form action="articulos_control.php" method="post" accept-charset="UTF-8"
                                  class="form-horizontal">
                                  <input type="hidden" value="5" name="accion"/>
                                  <input type="hidden" value="0" name="vart_cod"/>
                                  <div class="box-body">
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Descripcion</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="vart_descri" required="">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Porcentaje</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="vtipo_cod" required="">
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
            $("#mensaje").delay(4000).slideUp(200,function(){
                $(this).alert('close');
            });
        </script>
    </body>
</html>