<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Control Calidad</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    <link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>

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
                            echo $_SESSION['mensaje'];
                            $_SESSION['mensaje'] = '';
                            ?>
                        </div>  <!-- Termina mensaje -->
                    <?php endif; ?>
                    <div class="box-header with-border">
                        <h4 class="box-title">Control De Calidad</h4>
                        <div class="box-tools">
                                    <a href="control_calidad_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Registrar Control
                                    </a>
                                </div>
                    </div>
                    
                    <div class="box-body">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                   
                                    <th>N°</th>
                                    <th>N° Control</th>
                                    <th>Fecha Inspección</th>
                                    <th>Resultado</th>
                                    <th>Observaciónes</th>
                                    <th>Aprobado</th>
                                    <th>Empleado</th>
                                   <!-- <th>Estado</th> -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $control = consultas::get_datos("SELECT * FROM v_control_calidad");
                                if (is_array($control) && count($control) > 0) {
                                foreach ($control as $con) { ?>
                                    <tr>
                                       
                                        <td><?php echo htmlspecialchars($con['calidad_id']); ?></td>
                                        <td><?php echo htmlspecialchars($con['control_id']); ?></td>
                                        <td><?php echo htmlspecialchars($con['fecha_inspeccion']); ?></td>
                                        <td><?php echo htmlspecialchars($con['resultado']); ?></td>
                                        <td><?php echo htmlspecialchars($con['observaciones']); ?></td>
                                        <td><?php echo htmlspecialchars($con['aprobado']); ?></td>
                                        <td><?php echo htmlspecialchars($con['empleado']); ?></td>
                                    
                                        <td>
                                            <a href="control_calidad_print.php?vcalidad_id=<?php echo $con['calidad_id']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                            <span class="glyphicon glyphicon-print"></span></a>
    <a href="control_calidad_detalle.php?vcalidad_id=<?php echo $con['calidad_id'];?>" class="btn btn-primary btn-md" data-title="Detalles" rel="tooltip">
        <i class="fa fa-list"></i>                                                                    
    </a>     
    <?php 
    $estado = $con['estado'];
    $aprobado = $con['aprobado'];
    if (
    ($estado === 'FINALIZADO' && $aprobado === 'RECHAZADO') || 
    ($estado !== 'FINALIZADO' && $estado !== 'PENDIENTE REVISIÓN')
) {
?>
    <a href="control_calidad_editar.php?vcalidad_id=<?php echo $con['calidad_id']; ?>" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a> <?php } ?>
</td>
                                    </tr>
                                    <?php } 
} else { ?>
    <div class="alert alert-info flat">
        <span class="glyphicon glyphicon-info-sign"></span>
        No se han registrado el control de calidad...
    </div>
<?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
   
        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <!-- Archivos JS -->
    <?php require 'menu/js_lte.ctp'; ?>
    <!-- jQuery -->
    <script>
        // Inicialización de DataTables
        new DataTable('#example', {
            layout: {
                top2Start: 'pageLength',
                top2End: 'search',
                topStart: 'info',
                topEnd: 'paging',
            }
        });

        $(document).ready(function(){
            $('.btn-toggle').click(function(){
                var button = $(this);
                var id = button.data('id');
                
                // Busca la fila de detalles asociada, si existe
                var detailRow = $('#detail-row-' + id);
                
                if (detailRow.length) {
                    // Si la fila ya existe, la mostramos o la ocultamos
                    detailRow.toggle();
                    button.text(detailRow.is(':visible') ? '-' : '+');
                } else {
                    // Si la fila no existe, la creamos dinámicamente
                    var newRow = $('<tr id="detail-row-' + id + '"></tr>');
                    var newCell = $('<td colspan="7"></td>');
                    
                    // Agregar el botón de detalles con redirección
                    var detailButton = $('<button></button>')
                        .text('Detalles')
                        .addClass('btn btn-primary')
                        .click(function() {
                            window.location.href = 'control_calidad_view_art.php?ord_cod=' + id;
                        });
                    
                    newCell.append(detailButton);
                    newRow.append(newCell);
                    button.closest('tr').after(newRow);
                    button.text('-');
                }
            });
        });
    </script>
         <script> 
    $(document).ready(function() {
    $('#registrarcontrol').on('show.bs.modal', function(event) {
       
            var button = $(event.relatedTarget); // Botón que activó el modal
            var ordCod = button.data('ord_cod'); // Extrae el valor del data-ord_cod
            
            var modal = $(this);
            modal.find('.modal-body #ord_cod').val(ordCod);
            modal.find('.modal-body #hidden_ord_cod').val(ordCod); // Asigna el valor al campo oculto
        });

    $('.select2').select2();
    $('#example').DataTable();
});
</script>
</body>
</html>
