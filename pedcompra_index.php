<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>LP3 - Pedido de Compra</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="/taller/favicon.ico">
    
    <!-- Estilos CSS personalizados -->
    <style>
     /* Estilo para el estado "Pendiente" */
/* Estilo para el estado "Pendiente" */
.estado-pendiente {
    background-color: #4caf50; /* Verde */
    color: white;
    font-weight: bold;
    font-size: 0.8em; /* Tamaño de fuente más pequeño */
    border-radius: 5px;
    padding: 3px 6px; /* Reducir padding para que sea más compacto */
    text-align: center;
}

/* Estilo para el estado "Anulado" */
.estado-anulado {
    background-color: #f44336; /* Rojo */
    color: white;
    font-weight: bold;
    font-size: 0.8em; /* Tamaño de fuente más pequeño */
    border-radius: 5px;
    padding: 3px 6px; /* Reducir padding para que sea más compacto */
    text-align: center;
}
.estado-pendiente, .estado-anulado {
    padding: 3px 6px; /* Reducir padding */
}
/* Reducir la altura de las filas de la tabla */
table tbody tr {
    height: 30px; /* Ajustar a la altura que desees */
}
/* Reducir el ancho de las celdas de la tabla */
table td {
    padding: 5px; /* Reducir padding en celdas */
}

/* Estilo para el estado "Pendiente" */
.estado-pendiente {
    background-color: #f39c12;
color: white;
font-weight: bold;
border-radius: 12px;
padding: 5px 15px;
text-transform: uppercase;
display: inline-block;
font-size: 15px; /* Aumenta el tamaño del texto */

        }


/* Estilo para el estado "Anulado" */
.estado-anulado {
    background-color: #ff0000;  /* Fondo oscuro */
    color: white;            /* Texto blanco */
    font-weight: bold;       /* Texto en negrita */
    border-radius: 12px;     /* Bordes redondeados */
    padding: 5px 15px;       /* Relleno para dar espacio dentro del botón */
    text-transform: uppercase; /* Texto en mayúsculas */
    display: inline-block;    /* Hace que se comporte como un botón */
}
.estado-finalizado {
    background-color: #27ae60;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
        }

    </style>
    
    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; // Archivos CSS
    ?>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Cabecera y barra de herramientas -->
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
</svg> Pedido de Compra
                                </h3>
                                <div class="box-tools">
                                    <a href="pedcompra_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Nuevo Pedido
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-success" id="mensaje">
                                        <i class="glyphicon glyphicon-exclamation-sign"></i>
                                        <?php 
                                        echo $_SESSION['mensaje'];
                                        $_SESSION['mensaje'] = ''; 
                                        ?>
                                    </div>
                                <?php } ?>

                                <?php
                                $Pedido = consultas::get_datos("SELECT * FROM v_pedido_compra order by id_pedido desc");
                                if (!empty($Pedido)) { ?>
                                    <div class="table-responsive">
                                    <table id="pedidosTable" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th class="text-center">N°</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Observación</th>
            <th class="text-center">Usuario</th>
            <th class="text-center">Sucursal</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Pedido as $Ped) { 
            // Determinamos la clase CSS según el estado
            $claseEstado = '';
            switch ($Ped['estado']) {
                case 'FINALIZADO':
                    $claseEstado = 'estado-finalizado';
                    break;
                case 'PENDIENTE':
                    $claseEstado = 'estado-pendiente';
                    break;
                case 'ANULADO':
                    $claseEstado = 'estado-anulado';
                    break;
            }
        ?>
        <tr>
            <td class="text-center"><?php echo htmlspecialchars($Ped['id_pedido']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($Ped['fecha_pedido']); ?></td>
            <td class="<?php echo $claseEstado; ?>"><?php echo htmlspecialchars($Ped['estado']); ?></td>
            <td><?php echo htmlspecialchars($Ped['observacion']); ?></td>
            <td><?php echo htmlspecialchars($Ped['usuario']); ?></td>
            <td><?php echo htmlspecialchars($Ped['sucursal']); ?></td>
            <td class="text-center">
                        <?php if ($Ped['estado'] === "PENDIENTE") { ?>
                            <!-- Botones habilitados solo cuando el estado es "PENDIENTE" -->
                            <a href="pedcompra_print?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="pedcompra_edit.php?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-warning btn-sm" title="Editar">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <a onclick="anular('<?php echo $Ped['id_pedido'] . '_' . $Ped['id_pedido']; ?>')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#anular" title="Anular">
                                <i class="fa fa-remove"></i>
                            </a>
                            <a href="pedcompra_det.php?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-success btn-sm" title="Detalles">
                                <i class="glyphicon glyphicon-list"></i>
                            </a>
                          
                        <?php } ?>

                        <?php if ($Ped['estado'] === "ANULADO") { ?>
                            <!-- Botón habilitado solo cuando el estado es "ANULADO" -->
                            <a href="pedcompra_print?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="pedcompra_det.php?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-success btn-sm" title="Detalles">
                                <i class="glyphicon glyphicon-list"></i>
                            </a>
                        <?php } ?>
                        <?php if ($Ped['estado'] === "FINALIZADO") { ?>
                            <!-- Botón habilitado solo cuando el estado es "ANULADO" -->
                            <a href="pedcompra_print?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="pedcompra_det.php?vid_pedido=<?php echo $Ped['id_pedido']; ?>" class="btn btn-success btn-sm" title="Detalles">
                                <i class="glyphicon glyphicon-list"></i>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info">
                                        <i class="glyphicon glyphicon-info-sign"></i>
                                        No se ha registrado pedidos de compras.
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para anular -->
        <div class="modal fade" id="anular" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Cerrar"><i class="fa fa-remove"></i></button>
                        <h4 class="modal-title">Atención!</h4>
                    </div>
                    <div class="modal-body">
                        <div id="confirmacion" class="alert alert-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> NO</button>
                        <a id="si" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i> SI</a>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#pedidosTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                }
            });

            // Ocultar mensaje después de 4 segundos
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        });

        function anular(datos) {
            var dat = datos.split("_");
            $("#si").attr('href', 'pedcompra_control.php?vid_pedido=' + dat[0] + '&accion=2');
            $("#confirmacion").html(`
                <span class='glyphicon glyphicon-warning-sign'></span> 
                Desea anular el Pedido de Compra N° <strong>${dat[0]}</strong>?
            `);
        }
    </script>
</body>
</html>
