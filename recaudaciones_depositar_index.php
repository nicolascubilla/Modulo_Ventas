<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recaudaciones a Depositar</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <style>
    .badge-estado {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-depositado {
        background-color: #28a745;
        color: white;
    }

    .badge-anulado {
        background-color: #dc3545;
        color: white;
    }

    .table-actions {
        white-space: nowrap;
    }

    .card-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <!-- Encabezado -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h3 class="mb-0">Recaudaciones a Depositar</h3>
                            <p class="text-muted">Gestión de fondos recolectados para depósito bancario</p>
                        </div>
                        <div class="col-md-6 text-right">

                            <a href="nota_debito_ventas.php" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nueva Recaudación
                            </a>

                        </div>
                    </div>

                    <!-- Card Principal -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <h3 class="card-title">Listado de Recaudaciones</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablaRecaudaciones" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>N° Recaudación</th>
                                            <th>Fecha</th>
                                            <th>Arqueo Relacionado</th>
                                            <th>Total (₲)</th>
                                            <th>Banco Destino</th>
                                            <th>Estado</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Ejemplo de datos estáticos - En producción vendrían de la BD -->
                                        <tr>
                                            <td>REC-2025-001</td>
                                            <td>07/07/2025</td>
                                            <td>ARQ-2025-001</td>
                                            <td class="text-right">1,250,000</td>
                                            <td>Banco Continental</td>
                                            <td><span class="badge badge-estado badge-depositado">DEPOSITADO</span></td>
                                            <td>nico</td>
                                            <td class="table-actions">
                                                <a href="recaudacion_ver.php?id=1" class="btn btn-info btn-sm"
                                                    title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="recaudacion_imprimir.php?id=1" class="btn btn-secondary btn-sm"
                                                    title="Imprimir">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>REC-2025-002</td>
                                            <td>08/07/2025</td>
                                            <td>ARQ-2025-002</td>
                                            <td class="text-right">950,000</td>
                                            <td>Banco Nacional</td>
                                            <td><span class="badge badge-estado badge-pendiente">PENDIENTE</span></td>
                                            <td>nico</td>
                                            <td class="table-actions">
                                                <a href="recaudacion_ver.php?id=2" class="btn btn-info btn-sm"
                                                    title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="recaudacion_editar.php?id=2" class="btn btn-warning btn-sm"
                                                    title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="recaudacion_imprimir.php?id=2" class="btn btn-secondary btn-sm"
                                                    title="Imprimir">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Totales:</th>
                                            <th class="text-right">2,200,000</th>
                                            <th colspan="4"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="row">
                                <div class="col-md-6">
                                    Mostrando <strong>2</strong> de <strong>2</strong> registros
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-file-excel"></i> Exportar Excel
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-file-pdf"></i> Exportar PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

        <script>
        $(document).ready(function() {
            $('#tablaRecaudaciones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                "order": [
                    [1, "desc"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [7]
                    },
                    {
                        "className": "text-center",
                        "targets": [5, 7]
                    }
                ],
                "initComplete": function() {
                    $('.dataTables_filter input').addClass('form-control').css('width', '300px');
                    $('.dataTables_length select').addClass('form-control');
                }
            });
        });
        </script>
    </div>
</body>

</html>