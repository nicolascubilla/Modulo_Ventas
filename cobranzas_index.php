<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Módulo de Cobranzas</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .card-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .badge-estado {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .badge-pagado {
        background-color: #28a745;
        color: white;
    }

    .badge-parcial {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-moroso {
        background-color: #dc3545;
        color: white;
    }

    .table-actions {
        white-space: nowrap;
        width: 130px;
    }

    .summary-card {
        border-left: 4px solid #3c8dbc;
    }

    .progress {
        height: 10px;
        margin-bottom: 0;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Gestión de Cobranzas</h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="active">Cobranzas</li>
                </ol>
            </section>

            <section class="content">
                <!-- Resumen Estadístico -->
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box summary-card">
                            <span class="info-box-icon bg-blue"><i class="fas fa-hand-holding-usd"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cobrado Hoy</span>
                                <span class="info-box-number">₲ 3,250,000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box summary-card">
                            <span class="info-box-icon bg-green"><i class="fas fa-calendar-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cobrado Mes</span>
                                <span class="info-box-number">₲ 15,800,000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box summary-card">
                            <span class="info-box-icon bg-yellow"><i class="fas fa-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Morosidad</span>
                                <span class="info-box-number">₲ 4,500,000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box summary-card">
                            <span class="info-box-icon bg-red"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pendientes</span>
                                <span class="info-box-number">28</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Principal -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-actions">
                                    <h3 class="card-title">Registro de Cobranzas</h3>
                                    <div class="card-tools">

                                        <a href="cobranzas_add.php" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> Nueva Cobranza
                                        </a>

                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaCobranzas" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>N° Recibo</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Factura</th>
                                                <th>Monto (₲)</th>
                                                <th>Forma Pago</th>
                                                <th>Estado</th>
                                                <th class="table-actions">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Ejemplo de datos - Deberías reemplazar con consulta a tu BD -->
                                            <tr>
                                                <td>CB-2025-0001</td>
                                                <td>15/07/2025</td>
                                                <td>Cliente Ejemplo S.A.</td>
                                                <td>001-001-0000001</td>
                                                <td class="text-right">1,250,000</td>
                                                <td>Efectivo</td>
                                                <td><span class="badge badge-estado badge-pagado">PAGADO</span></td>
                                                <td class="table-actions">
                                                    <a href="cobranza_ver.php?id=1" class="btn btn-info btn-xs"
                                                        title="Ver">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="cobranza_imprimir.php?id=1"
                                                        class="btn btn-secondary btn-xs" title="Imprimir">
                                                        <i class="fa fa-print"></i>
                                                    </a>

                                                    <button class="btn btn-danger btn-xs btn-anular" title="Anular"
                                                        data-id="1">
                                                        <i class="fa fa-ban"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CB-2025-0002</td>
                                                <td>16/07/2025</td>
                                                <td>Otra Empresa S.R.L.</td>
                                                <td>001-001-0000002</td>
                                                <td class="text-right">750,000</td>
                                                <td>Tarjeta Crédito</td>
                                                <td><span class="badge badge-estado badge-pagado">PAGADO</span></td>
                                                <td class="table-actions">
                                                    <a href="cobranza_ver.php?id=2" class="btn btn-info btn-xs"
                                                        title="Ver">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="cobranza_imprimir.php?id=2"
                                                        class="btn btn-secondary btn-xs" title="Imprimir">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CB-2025-0003</td>
                                                <td>17/07/2025</td>
                                                <td>Cliente Moroso S.A.</td>
                                                <td>001-001-0000003</td>
                                                <td class="text-right">500,000</td>
                                                <td>Cheque</td>
                                                <td><span class="badge badge-estado badge-moroso">MOROSO</span></td>
                                                <td class="table-actions">
                                                    <a href="cobranza_ver.php?id=3" class="btn btn-info btn-xs"
                                                        title="Ver">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="cobranza_editar.php?id=3" class="btn btn-warning btn-xs"
                                                        title="Editar">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="cobranza_imprimir.php?id=3"
                                                        class="btn btn-secondary btn-xs" title="Imprimir">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Totales:</th>
                                                <th class="text-right">2,500,000</th>
                                                <th colspan="3"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    <div class="btn-group">
                                        <button class="btn btn-default">
                                            <i class="fas fa-download"></i> Exportar Excel
                                        </button>
                                        <button class="btn btn-default">
                                            <i class="fas fa-filter"></i> Filtros
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de Cuentas Pendientes -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Cuentas por Cobrar</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaCuentas" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Factura</th>
                                                <th>Fecha Venc.</th>
                                                <th>Monto (₲)</th>
                                                <th>Saldo (₲)</th>
                                                <th>Días Mora</th>
                                                <th>Estado</th>
                                                <th class="table-actions">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Cliente Moroso S.A.</td>
                                                <td>001-001-0000003</td>
                                                <td>10/07/2025</td>
                                                <td class="text-right">2,500,000</td>
                                                <td class="text-right">500,000</td>
                                                <td class="text-center">7</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-danger"
                                                            style="width: 80%"></div>
                                                    </div>
                                                    <span class="badge badge-estado badge-moroso">MOROSO</span>
                                                </td>
                                                <td class="table-actions">
                                                    <a href="cobranza_nueva.php?cuenta_id=3"
                                                        class="btn btn-success btn-xs">
                                                        <i class="fa fa-money-bill-wave"></i> Cobrar
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cliente Regular S.R.L.</td>
                                                <td>001-001-0000004</td>
                                                <td>20/07/2025</td>
                                                <td class="text-right">1,800,000</td>
                                                <td class="text-right">1,800,000</td>
                                                <td class="text-center">0</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning"
                                                            style="width: 100%"></div>
                                                    </div>
                                                    <span class="badge badge-estado badge-parcial">PENDIENTE</span>
                                                </td>
                                                <td class="table-actions">
                                                    <a href="cobranza_nueva.php?cuenta_id=4"
                                                        class="btn btn-success btn-xs">
                                                        <i class="fa fa-money-bill-wave"></i> Cobrar
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready(function() {
        // Inicializar DataTables
        $('#tablaCobranzas').DataTable({
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
                    "targets": [5, 6, 7]
                },
                {
                    "className": "text-right",
                    "targets": [4]
                }
            ]
        });

        $('#tablaCuentas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },
            "order": [
                [2, "asc"]
            ],
            "columnDefs": [{
                    "orderable": false,
                    "targets": [7]
                },
                {
                    "className": "text-center",
                    "targets": [2, 5, 6, 7]
                },
                {
                    "className": "text-right",
                    "targets": [3, 4]
                }
            ]
        });

        // Confirmación para anular cobranza
        $(document).on('click', '.btn-anular', function() {
            const idCobranza = $(this).data('id');
            Swal.fire({
                title: '¿Anular esta cobranza?',
                text: "Esta acción revertirá el pago en la cuenta",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, anular',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `cobranza_anular.php?id=${idCobranza}`;
                }
            });
        });
    });
    </script>
</body>

</html>