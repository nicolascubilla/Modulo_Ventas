<?php
require 'clases/conexion.php';
$detalles = consultas::get_datos("select * from v_detalle_pedventa "
        . "where ped_cod =".$_REQUEST['vped_cod']." and dep_cod=".$_REQUEST['vdep_cod']
        ." and art_cod=".$_REQUEST['vart_cod']);
//var_dump($detalles);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Agregar Item Venta</strong></h4>
</div>
<form action="ventas_dcontrol.php" method="post" accept-charset="UTF-8" class="form-horizontal">
    <input type="hidden" name="accion" value="1"/>
    <input type="hidden" name="vven_cod" value="<?php echo $_REQUEST['vven_cod'];?>"/>
    <input type="hidden" name="vdep_cod" value="<?php echo $detalles[0]['dep_cod'];?>"/>
    <input type="hidden" name="vart_cod" value="<?php echo $detalles[0]['art_cod'];?>"/>
    <div class="modal-body">
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Deposito:</label>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <input type="text"  class="form-control" value="<?php echo $detalles[0]['dep_descri'];?>"readonly=""/>                                                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Articulo:</label>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <input type="text"  class="form-control" value="<?php echo $detalles[0]['art_descri']." ".$detalles[0]['mar_descri'];?>"readonly=""/>                                                
            </div>
        </div>      
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cantidad:</label>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <input type="number" name="vven_cant" class="form-control" required="" autofocus="" 
                       placeholder="Ingrese la cantidad" value="<?php echo $detalles[0]['ped_cant'];?>" min="1"/>                                                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Precio:</label>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <input type="number" name="vven_precio" class="form-control" required="" 
                       placeholder="Ingrese el precio" value="<?php echo $detalles[0]['ped_precio'];?>" min="1"/>                                                
            </div>
        </div>        
    </div>
    <div class="modal-footer">
        <button type="reset" data-dismiss="modal" class="btn btn-default" 
                data-title="Cerrar ventana" rel="tooltip">
            <i class="fa fa-close"></i> Cerrar
        </button>
        <button type="submit" class="btn btn-success" data-title="Actualizar item" rel="tooltip">
            <i class="fa fa-plus"></i> Agregar
        </button>
    </div>
</form>
