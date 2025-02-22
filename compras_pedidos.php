<?php
require 'clases/conexion.php';
session_start();

$pedidos = consultas::get_datos("select * from v_pedido_cabcompra where prv_cod=" . $_REQUEST['vprv_cod'] .
                " and ped_estado='PENDIENTE' and id_sucursal=" . $_SESSION['id_sucursal']);
?>
<div class="col-lg-4 col-md-4 col-sm-4">
    <select class="form-control select2" name="vped_com">
        <option value="">Seleccione un pedido</option>
        <?php foreach ($pedidos as $pedido) { ?>
            <option value="<?php echo $pedido['ped_com'] ?>">
                <?php echo "N°:".$pedido['ped_com']." Fecha:".$pedido['ped_fecha']." Total:".$pedido['ped_total'] ?>
            </option>
        <?php } ?>
    </select> 
</div>



