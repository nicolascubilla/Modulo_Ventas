<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <title>LP3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; // Archivos CSS
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Cabecera Principal -->
    <?php require 'menu/header_lte.ctp'; ?>

    <!-- Menú Principal -->
    <?php require 'menu/toolbar_lte.ctp'; ?>

    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">

                    <!-- Mensaje de Error -->
                    <?php if (!empty($_SESSION['mensaje'])) : ?>
                        <div class="alert alert-danger" role="alert" id="mensaje">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php
                            echo $_SESSION['mensaje'];
                            $_SESSION['mensaje'] = '';
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Caja de Cargos -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-clipboard"></i>
                            <h3 class="box-title">Cargos</h3>
                            <div class="box-tools">
                                <a href="#" class="btn btn-primary btn-md" data-title="Agregar" rel="tooltip"
                                   data-toggle="modal" data-target="#registrar">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <form action="cargo_index.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input-group custom-search-form">
                                                        <input type="search" name="buscar" class="form-control" autofocus
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
                                </div>
                            </div>

                            <!-- Tabla de Cargos -->
                            <?php
                            $cargos = consultas::get_datos("select * from cargo where car_descri ilike '%" . (isset($_REQUEST['buscar']) ? $_REQUEST['buscar'] : "") . "%' order by car_cod");
                            if (!empty($cargos)) :
                            ?>
                                <table class="table table-striped table-condensed table-hover table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($cargos as $cargo) : ?>
                                        <tr>
                                            <td data-title='Descripción'><?php echo $cargo['car_descri']; ?></td>
                                            <td data-title='Acciones' class="text-center">
                                                <a onclick="editar('<?php echo $cargo['car_cod'] . "_" . $cargo['car_descri']; ?>')" class="btn btn-warning btn-md" data-title="Editar" 
                                                   rel="tooltip" data-toggle="modal" data-target="#editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a onclick="borrar('<?php echo $cargo['car_cod'] . "_" . $cargo['car_descri']; ?>')" class="btn btn-danger btn-md" data-title="Borrar" 
                                                   rel="tooltip" data-toggle="modal" data-target="#borrar">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <div class="alert alert-danger">
                                    <span class="glyphicon glyphicon-info-sign"></span>
                                    Aún no se registraron cargos...
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de Página -->
    <?php require 'menu/footer_lte.ctp'; ?>

    <!-- Modales -->
    <!-- Modal Registrar -->
    <div class="modal fade" id="registrar" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Cargos</strong></h4>
                </div>
                <form action="cargo_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                    <input type="hidden" name="accion" value="1"/>
                    <input type="hidden" name="vcar_cod" value="0"/>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Descripción:</label>
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <input type="text" name="vcar_descri" class="form-control" required autofocus placeholder="Ingrese la descripción del cargo"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" data-dismiss="modal" class="btn btn-default" data-title="Cerrar ventana" rel="tooltip">
                            <i class="fa fa-close"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success" data-title="Guardar Cargo" rel="tooltip">
                            <i class="fa fa-floppy-o"></i> Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editar" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> <strong>Editar Cargos</strong></h4>
                </div>
                <form action="cargo_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                    <input type="hidden" name="accion" value="2"/>
                    <input type="hidden" name="vcar_cod" value="0" id="cod"/>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Descripción:</label>
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <input type="text" name="vcar_descri" id="descri" class="form-control" required autofocus placeholder="Ingrese la descripción del cargo"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" data-dismiss="modal" class="btn btn-default" data-title="Cerrar ventana" rel="tooltip">
                            <i class="fa fa-close"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-warning" data-title="Guardar Cargo" rel="tooltip">
                            <i class="fa fa-edit"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Borrar -->
    <div class="modal fade" id="borrar" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                    <h4 class="modal-title custom-align"><strong>Atención!!!</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="confirmacion"></div>
                </div>
                <div class="modal-footer">
                    <a id="si" role="button" class="btn btn-primary">
                        <i class="fa fa-check"></i> Si
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-close"></i> No
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <?php require 'menu/js_lte.ctp'; ?>

    <!-- Custom Script -->
    <script>
        function editar(datos) {
            var dat = datos.split("_");
            $('#cod').val(dat[0]);
            $('#descri').val(dat[1]);
        }

        function borrar(datos) {
            var dat = datos.split("_");
            $('#si').attr('href', 'cargo_control.php?vcar_cod=' + dat[0] + '&vcar_descri=' + dat[1] + '&accion=3');
            $('#confirmacion').html('<span class="glyphicon glyphicon-question-sign"></span> ¿Desea borrar el cargo <strong>' + dat[1] + '</strong>?');
        }
    </script>
</div>
</body>
</html>
