<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura de Compra</title>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    
    <!-- Estilos personalizados -->
    <style>
        .estado-aprobado {
            background-color: #28a745; /* Verde */
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 10px;
            text-transform: uppercase;
            text-align: center;
        }
        .estado-anulado {
            background-color: #ff0000; /* Rojo */
            color: white;
            font-weight: bold;
            font-size: 1.2em;
            text-transform: uppercase;
        }
        .estado-finalizado {
            background-color: #006400; /* Verde oscuro */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        .estado-pendiente {
            background-color: #f39c12; /* Amarillo */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        .estado-pagado {
            font-weight: bold;
            color: black; /* Para "Pagado", sin fondo */
            text-transform: uppercase;
        }
        .btn-info {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-info:hover {
            background-color: #17a2b8;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>

    <?php 
    session_start();
    require 'menu/css_lte.ctp'; // Archivos CSS personalizados del sistema
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="currentColor" class="bi bi-file-earmark-richtext" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                                <h3 class="box-title">Factura de Compra</h3>
                                <div class="box-tools">
                                    <a href="factura_compra_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Agregar Factura
                                    </a>
                                </div>
                            </div>

                            <div class="box-body">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-success" role="alert" id="mensaje">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                                    </div>
                                <?php } ?> 

                                <?php
                                // Asegúrate de usar la vista correcta "v_factura_compra_cabecera"
                                $facturas = consultas::get_datos("SELECT * FROM v_factura_compra_cabecera");
                                if (!empty($facturas)) { ?>
                                    <div class="table-responsive">
                                        <table id="facturasTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">N° Factura</th>
                                                    <th class="text-center">N° Orden</th>
                                                    <th class="text-center">N° Fact. Proveedor</th>
                                                    <th class="text-center">Proveedor</th>
                                                    <th class="text-center">Fecha de Emisión</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Condición</th>
                                                    <th class="text-center">Monto Total</th>
                                
                                                    <th class="text-center">Sucursal</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($facturas as $factura) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $factura['id_factura']; ?></td>
                                                        <td class="text-center"><?php echo $factura['orden_id']; ?></td>
                                                        <td><?php echo $factura['id_factu_proveedor']; ?></td>
                                                        <td class="text-center"><?php echo $factura['proveedor']; ?></td>
                                                        <td class="text-center"><?php echo $factura['fecha_emision']; ?></td>
                                                        <td class="text-center">
                                                            <span class="estado 
                                                                <?php 
                                                                    echo $factura['estado_nombre'] == 'FINALIZADO' ? 'estado-finalizado' : 
                                                                         ($factura['estado_nombre'] == 'PENDIENTE' ? 'estado-pendiente' : 
                                                                         ($factura['estado_nombre'] == 'ANULADO' ? 'estado-anulado' : 
                                                                         ($factura['estado_nombre'] == 'PAGADO' ? 'estado-pagado' : ''))); 
                                                                ?>">
                                                                <?php echo $factura['estado_nombre']; ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo $factura['condicion']; ?></td>
                                                        <td class="text-right"><?php echo number_format($factura['monto_total']); ?></td>
                                                        <td><?php echo $factura['sucursal_descripcion']; ?></td>
                                                        <td><?php echo $factura['usuario_nick']; ?></td>
                                                        <td class="text-center">
                                                            <a href="factura_compra_print.php?id_factura=<?php echo $factura['id_factura']; ?>" 
                                                               class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="_blank">
                                                                <i class="glyphicon glyphicon-print"></i> Imprimir
                                                            </a>
                                                            <a href="factura_compra_detalles.php?id_factura=<?php echo $factura['id_factura']; ?>" 
                                                               class="btn btn-info btn-sm" 
                                                               data-title="Detalles" 
                                                               rel="tooltip">
                                                                <i class="fa fa-info-circle"></i> Detalles
                                                            </a>
                                                            <?php if ($factura['condicion'] !== 'CONTADO') { ?>
                                                            <a href="cuentas_a_pagar_compras.php?id_factura=<?php echo $factura['id_factura']; ?>" 
   class="btn btn-warning btn-sm" 
   data-title="Cuentas a Pagar" 
   rel="tooltip">
    <i class="fa fa-credit-card"></i> Cuentas a Pagar
</a>
<?php } ?> 


                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info flat">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        No se han registrado facturas de compra.
                                    </div> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>

        <?php require 'menu/js_lte.ctp'; ?>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#facturasTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                    }
                });
                $("#mensaje").delay(6000).slideUp(200);
            });
        </script>
    </div>
</body>
</html>
