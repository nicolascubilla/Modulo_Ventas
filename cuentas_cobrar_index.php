<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>LP3 - Cuentas a Cobrar</title>
    <link rel="shortcut icon" type="image/x-icon" href="/taller/favicon.ico">

    <style>
        .estado-pendiente {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
            font-size: 14px;
        }
        .estado-cancelado {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
            font-size: 14px;
        }
        table tbody tr { height: 30px; }
        table td { padding: 5px; }
    </style>

    <?php
    session_start();
    require 'menu/css_lte.ctp';  // CSS LTE
    ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php require 'menu/header_lte.ctp'; ?>
    <?php require 'menu/toolbar_lte.ctp'; ?>

    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                <i class="fa fa-credit-card"></i> Cuentas a Cobrar
                            </h3>
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
                            $cuentas = consultas::get_datos("SELECT * FROM v_cuentas_a_cobrar ORDER BY cta_cod DESC");
                            if (!empty($cuentas)) { ?>
                                <div class="table-responsive">
                                    <table id="cuentasTable" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">N° Cuenta</th>
                                                <th class="text-center">Cliente</th>
                                                <th class="text-center">Fecha Emisión</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Sucursal</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentas as $c) {
                                                $claseEstado = ($c['nombre'] === 'PENDIENTE')
                                                    ? 'estado-pendiente'
                                                    : 'estado-cancelado';
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= htmlspecialchars($c['cta_cod']); ?></td>
                                                    <td><?= htmlspecialchars($c['cliente']); ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($c['fecha_emision']); ?></td>
                                                    <td class="text-center <?= $claseEstado; ?>">
                                                        <?= htmlspecialchars($c['nombre']); ?>
                                                    </td>
                                                    <td class="text-center"><?= htmlspecialchars($c['suc_descri']); ?></td>
                                                    <td><?= htmlspecialchars($c['observaciones']); ?></td>
                                                    <td class="text-center">
                                                        <a href="cuentas_detalle.php?cta_cod=<?= $c['cta_cod']; ?>"
                                                           class="btn btn-success btn-sm" title="Ver Detalle">
                                                            <i class="glyphicon glyphicon-list"></i>
                                                        </a>
                                                        <?php if ($c['nombre'] === 'PENDIENTE') { ?>
                                                            <a href="cuentas_pago.php?cta_cod=<?= $c['cta_cod']; ?>"
                                                               class="btn btn-primary btn-sm" title="Procesar Pago">
                                                                <i class="fa fa-money"></i>
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
                                    No existen cuentas a cobrar registradas.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'menu/footer_lte.ctp'; ?>
</div>

<?php require 'menu/js_lte.ctp'; ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(function () {
    $('#cuentasTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json' }
    });
    $("#mensaje").delay(4000).slideUp(200, function () {
        $(this).alert('close');
    });
});
</script>
</body>
</html>
