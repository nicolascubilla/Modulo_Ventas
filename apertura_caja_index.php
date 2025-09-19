<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apertura Caja</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <style>
    /* Botón de Cierre/Apertura Compacto */
    .btn-close-apertura {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        background: linear-gradient(135deg, #ffc107 0%, #ffab00 100%);
        color: #212529;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 1px 5px rgba(255, 193, 7, 0.3);
        border: none;
        cursor: pointer;
        min-width: 32px;
        height: 32px;
    }

    .btn-close-apertura:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
    }

    .btn-close-apertura__icon {
        width: 16px;
        height: 16px;
        transition: transform 0.3s ease;
    }

    .btn-close-apertura:hover .btn-close-apertura__icon {
        transform: rotate(90deg);
    }

    /* Botón de Impresión Compacto */
    .btn-print-modern {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #495057;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #dee2e6;
        cursor: pointer;
        min-width: 32px;
        height: 32px;
    }

    .btn-print-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .btn-print-modern__icon {
        width: 16px;
        height: 16px;
    }

    /* Efectos comunes para ambos botones */
    .btn-close-apertura__effect,
    .btn-print-modern__pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-close-apertura:hover .btn-close-apertura__effect {
        opacity: 1;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    }

    .btn-print-modern:hover .btn-print-modern__pulse {
        opacity: 1;
        animation: printPulse 1.5s infinite;
    }

    @keyframes printPulse {
        0% {
            transform: scale(1);
            opacity: 0.6;
        }

        70% {
            transform: scale(1.05);
            opacity: 0;
        }

        100% {
            opacity: 0;
        }
    }

    /* Versión móvil - aún más compacta */
    @media (max-width: 768px) {

        .btn-close-apertura,
        .btn-print-modern {
            padding: 4px 8px;
            min-width: 28px;
            height: 28px;
            gap: 4px;
        }

        .btn-close-apertura__icon,
        .btn-print-modern__icon {
            width: 14px;
            height: 14px;
        }

        .btn-close-apertura__text,
        .btn-print-modern__text {
            display: none;
        }
    }

    /* Espaciado entre botones */
    .text-center>.btn-close-apertura,
    .text-center>.btn-print-modern {
        margin: 0 3px;
    }
    </style>

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
                                <h3 class="box-title">Apertura Cierre de Caja</h3>
                                <div class="box-tools">
                                    <a href="apertura_caja_add.php" class="btn-primary btn-sm pull-right"
                                        data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"> Registrar Apertura</i>
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
                                $apertura = consultas::get_datos("select * from v_apertura_cierre_caja_detalle order by id_caja asc");
                                if (!empty($apertura)) { ?>
                                <div class="table-responsive">
                                    <table id="aperturatale" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Caja</th>
                                                <th class="text-center">Fecha</th>
                                                <th class="text-center">Hora apertura</th>
                                                <th class="text-center">Monto apertura</th>
                                                <th class="text-center">Hora cierre</th>
                                                <th class="text-center">Monto cierre</th>
                                                <th class="text-center">Diferencia</th>
                                                <th class="text-center">Usuario apertura</th>
                                                <th class="text-center">Usuario cierre</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($apertura as $aper): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['id_caja']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['fecha_formateada']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['hora_apertura']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['monto_apertura']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['hora_cierre']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['monto_cierre']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['diferencia']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['usuario_apertura']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($aper['usuario_cierre']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($aper['estado']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="apertura_caja_print?vid_caja=<?php echo $aper['id_caja']; ?>"
                                                        class="btn-print-modern" title="Imprimir" target="print"
                                                        data-id="<?php echo $aper['id_caja']; ?>">

                                                        <span class="btn-print-modern__icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                                                <path
                                                                    d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                            </svg>
                                                        </span>

                                                        <span class="btn-print-modern__text">Imprimir</span>

                                                        <span class="btn-print-modern__pulse"></span>
                                                    </a>
                                                    <a href="apertura_caja_cierre.php?vid_caja=<?php echo $aper['id_caja']; ?>"
                                                        class="btn-close-apertura" title="Cierre Apertura"
                                                        data-id="<?php echo $aper['id_caja']; ?>">

                                                        <span class="btn-close-apertura__icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                                <path
                                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                            </svg>
                                                        </span>

                                                        <span class="btn-close-apertura__text">Cierre/Apertura</span>

                                                        <span class="btn-close-apertura__effect"></span>
                                                    </a>

                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign"></i>
                                    No se han registrado aperturas de caja.
                                </div>
                                <?php } ?>
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
                            <button class="close" data-dismiss="modal" aria-label="Cerrar"><i
                                    class="fa fa-remove"></i></button>
                            <h4 class="modal-title">Atención!</h4>
                        </div>
                        <div class="modal-body">
                            <div id="confirmacion" class="alert alert-danger"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i>
                                NO</button>
                            <a id="si" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i> SI</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>
        <!-- DataTables JS -->
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

        <script>
        $(document).ready(function() {
            $('#aperturatale').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true
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
    </div>
</body>

</html>