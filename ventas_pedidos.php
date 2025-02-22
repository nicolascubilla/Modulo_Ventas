<?php
require 'clases/conexion.php';
session_start();

$pedidos = consultas::get_datos("select * from v_pedido_cabventa where cli_cod =" . $_REQUEST['vcli_cod']
                . " and estado = 'PENDIENTE' and id_sucursal =" . $_SESSION['id_sucursal']);
?>
<div class="col-lg-4 col-sm-4 col-md-4">
    <select class = "form-control select2" name = "vped_cod">
       <option value = "">Seleccione un pedido</option>
       <?php foreach ($pedidos as $pedido) { ?>
           <option value="<?php echo $pedido['ped_cod']; ?>">
               <?php echo "N°:".$pedido['ped_cod']." FECHA:".$pedido['ped_fecha']
                       ." TOTAL: Gs.". number_format($pedido['ped_total'], 0,",","."); ?></option>
   <?php } ?>
   </select>    
</div>


