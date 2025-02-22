<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalle de Pedido de Compra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">

    <!-- Estilos -->
    <style>





   


        .titulo {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .detalle-cabecera {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .detalle-cabecera th, .detalle-cabecera td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .detalle-cabecera th {
            background-color: #808080;
            color: #fff;
        }

        .detalle-cabecera td {
            background-color: #F8F8FF;
        }

        .estado-anulado {
            color: red;
            font-weight: bold;
            font-size: 1.2em;
            text-transform: uppercase;
        }

        .table-detalle {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-detalle th, .table-detalle td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table-detalle th {
            background-color: #696969;
            color: #ffffff;
        }

        .table-detalle td {
            background-color: #F8F8FF;
        }

        .table-responsive {
            overflow-x: auto;
        }

   

        .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 15px;
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-info {
            background-color: #d9edf7;
            color: #31708f;
            border-color: #bce8f1;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
            border-color: #ebccd1;
        }
        .estado {
    font-weight: bold;
    color: white;
    border-radius: 10px;
    padding: 5px 10px;
    text-transform: uppercase;
    display: inline-block;
}

.estado-finalizado {
    background-color: #006400;
}

.estado-pendiente {
    background-color: #f39c12;
}
.estado-anulado {
        background-color: #ff0000; /* Fondo rojo */
        color: white; /* Texto blanco */
    }


    </style>
    <?php
    session_start();
    require 'menu/css_lte.ctp'; 
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Cabecera y barra de herramientas -->
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-13 col-md-13 col-sm-13">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h2 class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="22" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
  <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z"/>
</svg>Presupuesto de Compras</h2>
                                <div class="box-tools">
                                    <a href="presupuesto_compra_index.php" class="btn btn-primary btn-sm pull-right" title="Volver">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php
                                if (!empty($_GET['vpresupuesto_id'])) {
                                    $vpresupuesto_id = $_GET['vpresupuesto_id'];
                                    $presupuestocompra = consultas::get_datos("SELECT * FROM v_presupuesto_compra_cabecera_detalle_result WHERE presupuesto_id  = $vpresupuesto_id");

                                    if (!empty($presupuestocompra)) {
                                        $cabecera = $presupuestocompra[0];
                                        ?>
                                        <table class="table detalle-cabecera">
                                            <tr>
                                                <th>ID Presupuesto:</th>
                                                <td><?php echo $cabecera['presupuesto_id']; ?></td>
                                                <th>Fecha:</th>
                                                <td><?php echo $cabecera['fecha']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Estado:</th>
                                                <td class="text-center">
                                                <span class="estado 
        <?php 
            echo $cabecera['estado'] == 'FINALIZADO' ? 'estado-finalizado' : 
                 ($cabecera['estado'] == 'PENDIENTE' ? 'estado-pendiente' : 
                 ($cabecera['estado'] == 'ANULADO' ? 'estado-anulado' : '')); 
        ?>">
        <?php echo $cabecera['estado']; ?>
    </span>


</td>
                                                <th>Usuario:</th>
                                                <td><?php echo $cabecera['usuario']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Proveedor:</th>
                                                <td><?php echo $cabecera['prv_razonsocial']; ?></td>
                                                <th>Sucursal:</th>
                                                <td><?php echo $cabecera['sucursal']; ?></td>
                                            </tr>
                                        </table>

                                        <h4>Detalles del Presupuesto</h4>
                                        <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-detalle">
    <thead>
        <tr>
            <th>N°</th>
            <th>Material</th>
            <th>Cantidad</th>
            <th>Costo Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
    <tbody>
    <?php
    $totalGeneral = 0; // Inicializamos el total
    foreach ($presupuestocompra as $index => $detalle) {
        $subtotal = $detalle['cantidad'] * $detalle['costo_unitario'];
        $totalGeneral += $subtotal;
        echo "<tr>";
        echo "<td>" . ($index + 1) . "</td>";
        echo "<td>" . $detalle['material'] . "</td>";
        echo "<td>" . $detalle['cantidad'] . "</td>";
        echo "<td>" . number_format($detalle['costo_unitario'], 0, ",", ".") . "</td>";
        echo "<td>" . number_format($subtotal, 0, ",", ".") . "</td>";
        echo "</tr>";
    }
    ?>
    <!-- Fila para el total general -->
    <tr>
    <td colspan="4" style="text-align: left; border-top: 2px solid #000; font-weight: bold; padding-right: 10px;">
        Total General
    </td>
    <td style="font-weight: bold; color: #003366; border-top: 2px solid #000; text-align: center;">
        <?php echo number_format($totalGeneral, 0, ",", "."); ?>
    </td>
</tr>

</tbody>


   
</table>

                                        </div>
                                        <?php
                                    } else {
                                        echo "<div class='alert alert-info'>No se encontraron detalles para el presupuesto N° " . htmlspecialchars($vpresupuesto_id) . ".</div>";

                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>No se ha especificado un presupuesto válido.</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>

    <script>
        $(document).ready(function () {
            // Ocultar mensajes después de 4 segundos
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        });
    </script>
</body>
</html>
