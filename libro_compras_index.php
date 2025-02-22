<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Libro de Compras</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php 
    session_start();/*Reanudar sesion*/
    require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
        <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h3 class="box-title">Libro de Compras</h3>
                            </div>
                            <div class="box-body">
                                <!-- Buscador -->
                                <form method="get" action="">
                                    <div class="form-group">
                                        <label for="buscar_id_factura" class="control-label">Buscar Factura:</label>
                                        <div class="input-group">
                                            <input type="text" id="buscar_id_factura" name="buscar" class="form-control"  autocomplete="off"     placeholder="Ingrese ID Factura">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary">Buscar</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                                
                                <?php
                               
                                $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
                                $datos = consultas::get_datos("SELECT * FROM v_libro_compras WHERE id_factura::text ILIKE '%{$buscar}%'");
                                
                                if (!empty($datos)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID Libro</th>
                                                    <th>ID Factura</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Monto Total</th>
                                                    <th>IVA 5%</th>
                                                    <th>IVA 10%</th>
                                                    <th>Estado</th>
                                                    <th>Proveedor</th>
                                                    <th>Condición</th>
                                                    <th>Timbrado</th>
                                                    <th>Método de Pago</th>
                                                    <th>Sucursal</th>
                                                    <th>Usuario</th>
                                                    <th>ID Factura Proveedor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($datos as $dato) { ?>
                                                    <tr>
                                                        <td><?php echo $dato['id_libro']; ?></td>
                                                        <td><?php echo $dato['id_factura']; ?></td>
                                                        <td><?php echo $dato['fecha_registro']; ?></td>
                                                        <td><?php echo $dato['monto_total']; ?></td>
                                                        <td><?php echo $dato['suma_iva_5']; ?></td>
                                                        <td><?php echo $dato['suma_iva_10']; ?></td>
                                                        <td><?php echo $dato['estado_nombre']; ?></td>
                                                        <td><?php echo $dato['prv_razonsocial']; ?></td>
                                                        <td><?php echo $dato['condicion']; ?></td>
                                                        <td><?php echo $dato['timbrado']; ?></td>
                                                        <td><?php echo $dato['metodo_pago_nombre']; ?></td>
                                                        <td><?php echo $dato['sucursal']; ?></td>
                                                        <td><?php echo $dato['usuario']; ?></td>
                                                        <td><?php echo $dato['id_factu_proveedor']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Botón de Imprimir -->
                                    <button class="btn btn-warning" onclick="imprimirTabla()">Imprimir</button>
                                <?php } else { ?>
                                    <div class="alert alert-info">
                                        <strong>¡Información!</strong> No se encontraron resultados para la búsqueda.
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
        <script>
            function imprimirTabla() {
                var contenido = document.body.innerHTML;
                var tabla = document.querySelector('.table-responsive').innerHTML;
                document.body.innerHTML = tabla;
                window.print();
                document.body.innerHTML = contenido;
            }
        </script>
    </div>
</body>
</html>
