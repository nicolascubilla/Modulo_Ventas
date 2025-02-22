<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalles del Pedido Materia prima</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">

    <!-- Estilos -->
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            margin-left: 0;
            padding: 20px;
            background-color: #ffffff;
            min-height: calc(100vh - 100px); /* Altura ajustable para incluir el footer y cabecera */
        }

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
    background-color: #ff0000;  /* Fondo oscuro */
    color: white;            /* Texto blanco */
    font-weight: bold;       /* Texto en negrita */
    border-radius: 12px;     /* Bordes redondeados */
    padding: 5px 15px;       /* Relleno para dar espacio dentro del botón */
    text-transform: uppercase; /* Texto en mayúsculas */
    display: inline-block;    /* Hace que se comporte como un botón */
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
       .estado-pendiente {
    background-color: #f39c12;  /* Fondo oscuro */
    color: white;            /* Texto blanco */
    font-weight: bold;       /* Texto en negrita */
    border-radius: 12px;     /* Bordes redondeados */
    padding: 5px 15px;       /* Relleno para dar espacio dentro del botón */
    text-transform: uppercase; /* Texto en mayúsculas */
    display: inline-block;    /* Hace que se comporte como un botón */
}
.estado-FINALIZADO {
    background-color: #006400;  /* Fondo oscuro */
    color: white;            /* Texto blanco */
    font-weight: bold;       /* Texto en negrita */
    border-radius: 10px;     /* Bordes redondeados */
    padding: 5px 10px;       /* Relleno para dar espacio dentro del botón */
    text-transform: uppercase; /* Texto en mayúsculas */
    display: inline-block;    /* Hace que se comporte como un botón */
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
                             
                               Detalles del pedido Materia Prima</h2>
                                <div class="box-tools">
                                    <a href="pedidos_materia_prima_index.php" class="btn btn-primary btn-sm pull-right" title="Volver">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php
                                if (!empty($_GET['vpedido_id'])) {
                                    $vpedido_id = $_GET['vpedido_id'];
                                    $pedido = consultas::get_datos("SELECT * FROM v_pedido_materia_prima_detalle WHERE pedido_id = $vpedido_id");

                                    if (!empty($pedido)) {
                                        $cabecera = $pedido[0];
                                        ?>
                                        <table class="table detalle-cabecera">
                                            <tr>
                                                <th>ID Pedido:</th>
                                                <td><?php echo $cabecera['pedido_id']; ?></td>
                                                <th>N° orden:</th>
                                                <td><?php echo $cabecera['ord_cod']; ?></td>
                                                <th>Fecha:</th>
                                                <td><?php echo $cabecera['fecha']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Estado:</th>
                                                <td class="text-center">
    <span class="<?php 
        echo $cabecera['estado'] == 'FINALIZADO' ? 'estado-FINALIZADO' : 
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
                                                <th>Sucursal:</th>
                                                <td><?php echo $cabecera['usuario']; ?></td>
                                                <th>Equipo De Trabajo:</th>
                                                <td><?php echo $cabecera['nombre_equipo']; ?></td>
                                            </tr>
                                        </table>

                                        <h4>Detalles de la orden</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-detalle">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Materiales</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($pedido as $index => $detalle) {
                                                        echo "<tr>";
                                                        echo "<td>" . ($index + 1) . "</td>";
                                                        echo "<td>" . $detalle['nombre_material'] . "</td>";
                                                        echo "<td>" . $detalle['cantidad'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                    } else {
                                        echo "<div class='alert alert-info'>No se encontraron detalles para el pedido N° $vpedido_id.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>No se ha especificado una orden válido.</div>";
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
