<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agregar Factura de Compras</title>
    <?php session_start(); require 'menu/css_lte.ctp'; ?>
    <style>
        .form-group { margin-top: 15px; }
        .control-label { font-weight: bold; }
        .table th, .table td { text-align: center; vertical-align: middle; }
        .table th { background-color: #f4f4f4; }
        .table { margin-top: 15px; }
        .row { margin-bottom: 15px; }
        .form-horizontal .col-lg-3, .form-horizontal .col-lg-6 { margin-bottom: 15px; }

        .title-container {
            display: flex;
            align-items: center; /* Alinea el SVG y el título verticalmente */
            gap: 10px; /* Espaciado entre la imagen y el título */
        }

        .icon {
            width: 24px; /* Ajusta el tamaño del SVG */
            height: auto; /* Mantén las proporciones */
        }

        .title {
            font-size: 2.5rem; /* Ajusta el tamaño del título */
            margin: 0; /* Elimina márgenes innecesarios */
        }

        #vdep_cod {
            margin-top: -0px; /* Ajusta este valor según necesites */
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
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <div class="title-container">
                                    <!-- Ícono SVG -->
                                    <img src="img/icons8-ajustes (1).gif" alt="Ajustes" width="50" height="50">
                                    <h2 class="title">Ajustes de Mercaderias</h2>
                                </div>
                                
                                <div class="box-tools">
                                    <a href="ajuste_compra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>

                            <form action="ajustes_compras_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1">
                                <div class="box-body">
                                    <div class="container">
                                        <!-- Fila 1 - Factura Compra, Buscar Factura, N° Factura Proveedor -->
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label for="vdep_cod" class="control-label">Depósito:</label>
                                                <select class="form-control select2" name="vdep_cod" id="vdep_cod" onchange="cargarMateriales(this.value)" required>
                                                    <option value="">Seleccione un Depósito</option>
                                                    <?php 
                                                    $depositos = consultas::get_datos("SELECT dep_cod, dep_descri 
                                                                                       FROM deposito 
                                                                                       WHERE id_sucursal = ".$_SESSION['id_sucursal']." 
                                                                                       ORDER BY dep_descri");
                                                    foreach ($depositos as $dep) { ?>
                                                        <option value="<?php echo $dep['dep_cod']; ?>">
                                                            <?php echo $dep['dep_descri']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="fecha_ajuste" class="control-label">Fecha Ajuste:</label>
                                                <?php
                                                date_default_timezone_set('America/Asuncion');
                                                $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_ajuste");
                                                $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_ajuste']));
                                                ?>
                                                <input type="datetime-local" id="fecha_ajuste" class="form-control" value="<?php echo $fecha_formateada; ?>" readonly>
                                                <input type="hidden" name="vfecha_ajuste" value="<?php echo $fecha[0]['fecha_ajuste']; ?>">
                                            </div>

                                            <div class="col-lg-4">
                                        
                                            <label for="usuario" class="control-label">Usuario:</label>
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
                                        </div>
                                    </div>

                                        
                                        <!-- Fila con Descripción --> 
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <label for="descripcion" class="control-label">Descripción:</label>
                                                <textarea id="descripcion" name="vdescripcion" class="form-control" rows="4" placeholder="Ingrese una descripción..."></textarea>
                                            </div>
                                        </div>

                                        <!-- Fila 5 - Detalle de la Orden -->
                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <h4>Detalle de Materiales en el Depósito:</h4>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Material</th>
                                                            <th>Existencia</th>
                                                          <!--  <th>Cantidad Ajustar</th> -->
                                                            <th>Encontrada</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detalle_materiales">
                                                        <tr>
                                                            <td colspan="4">Seleccione un depósito para cargar los materiales.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-floppy-o"></i> Registrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php require 'menu/footer_lte.ctp'; ?>

    <script>
    function cargarMateriales(dep_cod) {
    if (dep_cod) {
        $.ajax({
            url: "get_materiales_ajustes.php",
            type: "POST",
            dataType: "json",
            data: { dep_cod: dep_cod },
            success: function (response) {
                if (response && response.length > 0) {
                    let html = "";
                    response.forEach(function(item) {
                        html += `
                            <tr>
                                <td>${item.nombre_material}</td>
                                <td class="existencia">${item.existencia}</td>
                               
                                <td>
                               
                                <input type="hidden" name="materiales[]" value="${item.material_id}">
                                    <input type="number" name="encontrada[${item.material_id}]" class="form-control encontrada-campo" 
                                           value="${item.encontrada}" data-material-id="${item.material_id}" 
                                           data-existencia="${item.encontrada}" min="0" required>
                                </td>
                            </tr>`;
                    });
                    $("#detalle_materiales").html(html);
                } else {
                    $("#detalle_materiales").html('<tr><td colspan="4">No hay materiales en este depósito.</td></tr>');
                }
            },
            error: function () {
                console.error("Error al cargar materiales.");
            },
        });
    } else {
        $("#detalle_materiales").html('<tr><td colspan="4">Debe seleccionar un depósito.</td></tr>');
    }
}

// Delegación de eventos para inputs dinámicos
$(document).on("input", ".encontrada-campo", function() {
    let material_id = $(this).data("material-id");
    let existencia = parseInt($(this).data("existencia")) || 0;
    let encontrada = parseInt($(this).val()) || 0;

    // Validar que no sea negativo
    if (encontrada < 0) encontrada = 0;

    // Calcular diferencia
    let diferencia = encontrada - existencia;

    // Actualizar input de ajuste (que se envía al backend)
    $(this).closest("tr").find(`input[name='ajuste[${material_id}]']`).val(diferencia);
});

// Validación antes de enviar el formulario
$('form').on('submit', function(e) {
    let tieneAjustes = false;

    $('.ajuste-cantidad').each(function() {
        if (parseInt($(this).val()) !== 0) {
            tieneAjustes = true;
            return false;
        }
    });

    if (!tieneAjustes) {
        e.preventDefault();
        alert('Debe ingresar al menos un ajuste con cantidad diferente de cero.');
        return false;
    }
});


    </script>
    
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>