<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" type="image/x-icon" href="/taller/favicon.ico">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
      

    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; ?>
    <style>
        .tailwind-btn {
    background-color: #3b82f6 !important;
    color: white !important;
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 6px;
}

    </style>
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
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
                            echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8');
                            $_SESSION['mensaje'] = ''; // Limpiar mensaje después de mostrarlo
                            ?>
                        </div>  
                    <?php endif; ?>
                    
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <img width="48" height="48" src="https://img.icons8.com/fluency/48/cost.png" alt="cost"/>
                            Costo de Producción
                        </h4>
                       

                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="costo" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Control ID</th>
                                       
                                        <th>ID Calidad</th>
                                        <th>Fecha Producción</th>
                                        <th>ESTADO</th>
                                        <th>TIEMPO INVERTIDO</th>
                                        <th>DESCRIPCION</th>
                                        <th>SUCURSAL</th>
                                        <th>ACCIONES</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
    <?php 
    $costo = consultas::get_datos("SELECT * FROM v_costo_produccion_cab");

    if (!empty($costo)) {
        foreach ($costo as $co) { ?>
            <tr>
                <td><?= htmlspecialchars($co['control_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($co['calidad_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($co['fecha_avance'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($co['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($co['tiempo_invertido'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($co['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($co['suc_descri'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="text-center">
                    <a href="costo_produccionprint.php?control_id=<?= $co['control_id']; ?>" 
                        class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="_blank">
                        <i class="glyphicon glyphicon-print"></i> Imprimir
                    </a>
                    <a href="costo_produccion_detalle.php?control_id=<?= $co['control_id']; ?>" 
                        class="btn btn-info btn-sm" data-title="Detalles" rel="tooltip">
                        <i class="fa fa-info-circle"></i> Detalles
                    </a>
                </td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="7" class="text-center">
                <div class="alert alert-info">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    No se encontraron registros de mermas...
                </div>
            </td>
        </tr>
    <?php } ?>
</tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       
     
    </div>

        
       
    <?php require 'menu/footer_lte.ctp'; ?>
       
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
   
    <!-- jQuery -->
   
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- DataTables Buttons (solo si usas 'copy', 'csv', 'excel', 'pdf', 'print') -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Inicialización segura -->
<script>
    $(function () {
        // Inicializa DataTables
        $('#costo').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });
    });
</script>


</body>
</html>
