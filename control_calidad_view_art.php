<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .content-wrapper {
            padding: 20px;
        }
        .box {
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .box-header {
            background-color: #f7f7f7;
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }
        .box-title {
            margin: 0;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; 
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        
        <div class="content-wrapper">
            <div class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="bi bi-file-earmark-ppt" style="font-size: 2rem;"></i>
                        <h4 class="box-title">Detalle Presupuesto</h4>
                        <div class="box-tools">
                            <a href="control_calidad_index.php" class="btn btn-primary btn-md" 
                               data-title="Volver" rel="tooltip"> 
                                <i class="fa fa-arrow-left"></i> 
                            </a>                                          
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php 
                            $ord_cod = $_GET['ord_cod'] ?? null;

                            if ($ord_cod) {
                                $contrl_det = consultas::get_datos("SELECT * FROM v_control_calidad_articulos WHERE ord_cod=".$ord_cod);

                                if (!empty($contrl_det)) { ?>
                                    <div class="box-header">
                                        <i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalles de la Producción</h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-condensed table-hover dt-responsive">
                                            <thead>
                                                <tr>
                                                    <th>N° orden</th>
                                                    <th>N° Presupuesto</th>
                                                    <th>Estado</th>
                                                    <th>Deposito</th>
                                                    <th>Articulo</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($contrl_det as $det) { ?>                                                               
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($det['ord_cod'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($det['pre_cod'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo ($det['ord_estado'] === "Completado") ? "<span style='color:green;'><strong>".$det['ord_estado']."</strong></span>" : $det['ord_estado']; ?></td>
                                                        <td><?php echo htmlspecialchars($det['dep_descri'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($det['art_descri'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($det['pre_cant'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>                                                
                                    </div>
                                <?php } else { ?>
                                    <div class="box-header">
                                        <h3 class="box-title">No se encontraron detalles para este presupuesto</h3>
                                    </div>
                                <?php } 
                            } else { ?>
                                <div class="box-header">
                                    <h3 class="box-title">Código de presupuesto no proporcionado.</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
    </div>
   

    <!-- jQuery (necessary for DataTables and Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
                ],
                "language": {
                    "sEmptyTable": "No hay datos disponibles en la tabla",
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "sInfoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "sLengthMenu": "Mostrar _MENU_ entradas",
                    "sLoadingRecords": "Cargando...",
                    "sProcessing": "Procesando...",
                    "sSearch": "Buscar:",
                    "sZeroRecords": "No se encontraron resultados",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                }
            });
        });
    </script>
</body>
</html>
