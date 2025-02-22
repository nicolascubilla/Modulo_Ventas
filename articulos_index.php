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
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Articulos</h3>
                                    <div class="box-tools">
                                        <a href="articulos_print.php" 
                                           class="btn btn-default pull-right btn-sm" 
                                           data-title="Imprimir" rel="tooltip" target="_blank"> 
                                            <i class="fa fa-print"></i> </a>
                                        <a  href="articulos_add.php" 
                                            class="btn btn-primary btn-sm" role="button">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>  
                                </div><!--BOX HEADER-->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 col-md-12">
                                            <!--BUSCADOR-->
                                            <form action="articulos_index.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-xs-12 col-md-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control" name="buscar"
                                                                       placeholder="Buscar..." autofocus=""/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary btn-flat"
                                                                            data-title="buscar" data-placement="bottom"
                                                                            rel="tooltip"><span class="fa fa-search"></span></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php 
                                            $valor='';
                                            if(isset($_REQUEST['buscar'])){
                                                $valor=$_REQUEST['buscar'];
                                            }
                                            $articulos= consultas::get_datos("select*from v_articulo where (art_cod||art_descri||mar_descri||tipo_descri)".
                                                    "like trim(upper('%".$valor."%')) order by art_cod");
                                            if (!empty($articulos)) { ?>
                                            <div class="table-responsive">
                                                <table class=" table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Cod. barra</th>
                                                            <th>Articulo</th>
                                                            <th>Prec. compra</th>
                                                            <th>Prec. venta</th>
                                                            <th>Impuesto</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                         foreach ($articulos as $articulo) { ?>
                                                        <tr>
                                                            <td data-title='Codigo'> <?php echo $articulo['art_cod']?> </td>
                                                            <td data-title='Cod. barra'> <?php echo $articulo['art_codbarra']?> </td>
                                                            <td data-title='Articulo'> <?php echo $articulo['art_descri']." ".$articulo['mar_descri']?> </td>
                                                            <td data-title='Precioc'> <?php echo $articulo['art_precioc']?> </td>
                                                            <td data-title='Articulo'> <?php echo $articulo['art_preciov']?> </td>
                                                            <td data-title='Articulo'> <?php echo $articulo['tipo_descri']?> </td>
                                                            <td data-title='acciones'class="text-center">
                                                                <a href="articulos_edit.php?vart_cod=<?php echo $articulo['art_cod']?>"
                                                                   class="btn btn-warning btn-sm" role='button'
                                                                   data-title='editar' rel="tooltip" data-placement='top'>
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>
                                                                <a onclick="borrar(<?php echo"'".$articulo['art_cod'].
                                                                        "_".$articulo['art_descri']."_".$articulo['mar_descri']."'"; ?>)" 
                                                                   class="btn btn-danger btn-sm" role='button'
                                                                   data-title='borrar' rel="tooltip" data-placement='top'
                                                                   data-toggle="modal" data-target="#borrar">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                         <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado Articulos...
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
                  <div class="modal fade" id="borrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Atenci&oacute;n!!!</strong></h4>
                              </div>
                              <div class="modal-body">
                                  <div class="alert alert-warning" id="confirmacion"></div>
                              </div>
                              <div class="modal-footer">
                                  <a id="si" role="button" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span>Si</a>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">
                                      <span class="glyphicon glyphicon-remove"></span>No</button>
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
            function borrar(datos){
                var dat= datos.split("_");
                $("#si").attr('href','articulos_control.php?vart_cod='+dat[0]+'&vart_descri='+dat[1]+"&vmar_descri="+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
                   Desea borrar el articulo<i><strong> '+dat[1]+" "+dat[2]+'</strong></i>?');
            }
        </script>
        <script>
            $('.modal').on('showm.bs.modal', function() {
              $(this).find('input:text:visible:first').focus();
            });
        </script>
        
    </body>
</html>