<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    <link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet"> <!-- Mejora de estilos para DataTable -->
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet"> <!-- Estilos para botones de exportación -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper"> 
            <div class="content">
                <div class="box box-primary">
                    <!-- Mensaje de Error -->
                    <?php if (!empty($_SESSION['mensaje'])) : ?>
                        <div class="alert alert-danger" role="alert" id="mensaje">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php
                            echo htmlspecialchars($_SESSION['mensaje']);
                            $_SESSION['mensaje'] = '';
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="box-header with-border">
                        <h4 class="box-title">Detalles del Articulo</h4>
                    
                    <div class="box-tools">
                            <a href="pedidos_materia_prima_index.php" class="btn btn-primary btn-md" data-title="Volver" rel="tooltip">
                                <i class="fa fa-arrow-left"></i> 
                            </a>   
                            </div> 
                        </div>
                    <div class="box-body">
                        <?php 
                        if (isset($_GET['ord_cod'])) {
                            $ord_cod = $_GET['ord_cod'];
                            $pedido = consultas::get_datos("SELECT * FROM v_pedido_articulo WHERE ord_cod = '$ord_cod'");
                            
                            if (!empty($pedido)) { ?>
                                <table id="example" class="display table table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>N° Calidad</th>
                                            <th>N° Orden</th>
                                            <th>N° Presupuesto</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>Articulo</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedido as $pedi) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($pedi['calidad_id']); ?></td>
                                                <td><?php echo htmlspecialchars($pedi['ord_cod']); ?></td>
                                                <td><?php echo htmlspecialchars($pedi['pre_cod']); ?></td>
                                                <td><?php echo htmlspecialchars($pedi['cliente']); ?></td>
                                                <td><?php echo htmlspecialchars($pedi['ord_estado']); ?></td>
                                                <td><?php echo htmlspecialchars($pedi['art_descri']); ?></td>
                                                <td><?php echo htmlspecialchars($pedi['pre_cant']); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="box-header">
                                    <h3 class="box-title">No se encontraron detalles para este pedido</h3>
                                </div>
                            <?php } 
                        } else { ?>
                            <div class="box-header">
                                <h3 class="box-title">Código de pedido no proporcionado.</h3>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    
        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <!-- Archivos JS -->
    <?php require 'menu/js_lte.ctp'; ?>
    
    <!-- jQuery and DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>
</html>
