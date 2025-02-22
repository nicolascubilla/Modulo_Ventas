<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/img/favicon.ico">
        <title>CLIENTES | LP3</title>
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
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form action="grupo_index.php" method="post" accept-charset="utf8" class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <div class="input-group custom-search-form">
                                                <input type="search" class="form-control" name="buscar" placeholder="Buscar... "autofocus/>
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-primary btn-flat" 
                                                            data-title="Buscar" data-placement="bottom" rel="tooltip">
                                                        <span class="fa fa-search"></span>
                                                    </button>
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
                                $grupos = consultas::get_datos("select * from clientes "
                                        . "where (cli_cod||trim(upper(cli_nombre))) "
                                        . "like trim(upper('%".$valor."%')) order by cli_cod");
                            ?>
                            <?php if(!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                            <?php }?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-clipboard"></i>
                                    <h3 class="box-title">Clientes</h3>
                                    <div class="box-tools">
                                        <a href="" class="btn btn-primary btn-med"
                                           data-title="Agregar" rel="tooltip" role="button"
                                           data-toggle="modal" data-target="#registrar">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="clientes_print.php" class="btn btn-default btn-md" rel="tooltip" data-title="Imprimir">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div> <!--Fin box header-->
                                <div class="box-body">
                                    <?php $clientes = consultas::get_datos("select * from clientes order by cli_cod"); 
                                    if(!empty($clientes)) { ?>
                                    <table class="table table-striped table-condensed table-hover table-responsive">
                                        <thead>                                          
                                            <tr>
                                                <th>CI</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Telefono</th>
                                                <th>Direccion</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  foreach ($clientes as $cliente) { ?>
                                            <tr>
                                                <td data-title="CI"><?php echo $cliente['cli_ci']?></td>
                                                <td data-title="Nombre"><?php echo $cliente['cli_nombre']?></td>
                                                <td data-title="Apellido"><?php echo $cliente['cli_apellido']?></td>
                                                <td data-title="Telefono"><?php echo $cliente['cli_telefono']?></td>
                                                <td data-title="Direccion"><?php echo $cliente['cli_direcc']?></td>
                                                <td data-title="Acciones" class="text-center">
                                                    <a onclick="editar(<?php echo "'".$cliente['cli_cod']."_".$cliente['cli_nombre']."'";?>)" class="btn btn-warning btn-md " data-title="Editar" 
                                                       rel="tooltip" data-toggle="modal" data-target="#editar">
                                                        <i class="fa fa-edit"></i>
                                                    </a>       
                                                    <a onclick="borrar" class="btn btn-danger btn-md " data-title="Borrar"
                                                       rel="tooltip" data-toggle="modal" data-target="#borrar">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                             <?php } ?> 
                                        </tbody>
                                    </table> 
                                    <?php }else { ?>
                                    <div class="alert alert-danger">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        Aún no se registraron clientes...
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                  <!-- INICIO MODAL REGISTRAR -->
<div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="registrarLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="registrarLabel"><i class="fa fa-plus"></i> Registrar Cliente</h4>
            </div>
            <form action="clientes_control.php" method="post" class="form-horizontal">
                <input type="hidden" name="accion" value="1"/>
                <input type="hidden" name="vcli_cod" value="0"/>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vcli_ci" class="control-label col-sm-2">CI:</label>
                        <div class="col-sm-10">
                            <input type="text" name="vcli_ci" id="vcli_ci" class="form-control" required placeholder="Ingrese el CI del Cliente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcli_nombre" class="control-label col-sm-2">Nombre:</label>
                        <div class="col-sm-10">
                            <input type="text" name="vcli_nombre" id="vcli_nombre" class="form-control" required placeholder="Ingrese el nombre del Cliente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcli_apellido" class="control-label col-sm-2">Apellido:</label>
                        <div class="col-sm-10">
                            <input type="text" name="vcli_apellido" id="vcli_apellido" class="form-control" required placeholder="Ingrese el apellido del Cliente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcli_telefono" class="control-label col-sm-2">Teléfono:</label>
                        <div class="col-sm-10">
                            <input type="text" name="vcli_telefono" id="vcli_telefono" class="form-control" required placeholder="Ingrese el teléfono del Cliente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcli_direcc" class="control-label col-sm-2">Dirección:</label>
                        <div class="col-sm-10">
                            <input type="text" name="vcli_direcc" id="vcli_direcc" class="form-control" required placeholder="Ingrese la dirección del Cliente">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-close"></i> Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-floppy-o"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- FIN MODAL REGISTRAR -->

                  <!-- INICO MODAL EDITAR-->
                  <div class="modal fade" id="editar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-lable="Close"><i class="fa fa-close"></i></button>
                                  <h4 class="modal-title"><i class="fa fa-edit"></i><strong>Editar Clientes</strong></h4>
                              </div>
                              <form action="clientes_control.php" method="post" acept-charset="UTF-8" class="form-horizontal">
                                  <input type="hidden" name="accion" value="2"/>
                                  <input type="hidden" name="vcli_cod" value="0" id="cod"/>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-14 col-sm-2">CI:</label>
                                          <div class="col-lg-10 col-md-10" col-sm-10>
                                              <input type="text" name="vcli_ci" id="descri" pattern="^\d+$"  class="form-control" required="" autofocus="" placeholder="Ingrese el CI del Cliente"]/>
                                          </div><br><br>
                                          <label class="control-label col-lg-14 col-sm-2">Nombre:</label>
                                          <div class="col-lg-10 col-md-10" col-sm-10>
                                              <input type="text" name="vcli_nombre" id="descri"  class="form-control" required="" autofocus="" placeholder="Ingrese el nombre del Cliente"]/>
                                          </div><br><br>
                                          <label class="control-label col-lg-14 col-sm-2">Apellido:</label>
                                          <div class="col-lg-10 col-md-10" col-sm-10>
                                              <input type="text" name="vcli_apellido" id="descri"  class="form-control" required="" autofocus="" placeholder="Ingrese el apellido del Cliente"]/>
                                          </div><br><br>
                                          <label class="control-label col-lg-14 col-sm-2">Telefono:</label>
                                          <div class="col-lg-10 col-md-10" col-sm-10>
                                              <input type="text" name="vcli_telefono" id="descri"  class="form-control" required="" autofocus="" placeholder="Ingrese el telefono del Cliente"]/>
                                          </div><br><br>
                                          <label class="control-label col-lg-14 col-sm-2">Direccion:</label>
                                          <div class="col-lg-10 col-md-10" col-sm-10>
                                              <input type="text" name="vcli_direcc" id="descri"  class="form-control" required="" autofocus="" placeholder="Ingrese la direccion del Cliente"]/>
                                          </div><br><br>
                                      </div>
                                  </div> 
                                  <div class="modal-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-default" data-title="Cerar Ventana" rel="tooltip"> 
                                          <i class="fa fa-close"></i> Cerrar
                                      </button>
                                      <button type="submit" class="btn btn-warning pull-right" data-title="Actualizar Registro" rel="tooltip">
                                        <i class="fa fa-edit"></i> Actualizar
                                      </button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL EDITAR-->
                  
                  <!-- INICO MODAL ELIMINAR-->
                  <div class="modal fade" id="borrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-lable="Close"><i class="fa fa-close"></i></button>
                                  <h4 class="modal-title custom-align" id=""></i><strong>Atencion!!!</strong></h4>
                              </div>
                              <div class="modal-body">
                                  <div class="aler alert-danger" id="confirmacion"></div>
                              </div>
                                  <div class="modal-footer">
                                      <a id="si" role="button" class="btn btn-primary" data-title="Si">
                                          <i class="glyphicon glyphicon-ok-sign"></i> Si
                                      </a>
                                      <button type="reset" data-dismiss="modal" class="btn btn-default" data-title="No" rel="tooltip"> 
                                          <i class="fa fa-close"></i> NO
                                      </button>
                                      
                                  </div>
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL BORRAR-->
            </div>                  
            <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
            <script>
            $("#mensaje").delay(4000).slideUp(200,function(){
                $(this).alert('close');
            });
            $(".modal").on("shown.bs.modal",function(){
               $(this).find("input:text:visible:first").focus ();
            });
            </script>
            <script>
                function editar(datos){
                    var dat = datos.split("_");
                    $("#cod").val(dat[0]);
                   $("#descri").val(dat[1]);
                }
            </script>
            <script>
                function borrar(datos){
                    var dat = datos.split("_");
                    $("#si").attr('href','clientes_control.php?vcli_cod ='+dat[0]+'&accion=3');
                    $("#confirmacion").html("<span class='glyphicon glyphicon-warning-sign'></span> Desea borrar el cliente <strong>"+dat[1]+"</strong>?");
                }
            </script>
            <script>
   document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('input[name="vcli_ci"]').addEventListener('keypress', function(e) {
        if (e.key === '.') {
            e.preventDefault();
        }
    });
});

</script>

            
    </body>
</html>