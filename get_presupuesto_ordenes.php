<?php
require 'clases/conexion.php';

$pre_cod = $_POST['pre_cod']; 

if ($pre_cod) {
    
    $detalles = consultas::get_datos("SELECT art_cod, art_descri, pre_cant FROM v_presupuestos_pendientes WHERE pre_cod = $pre_cod");

    if ($detalles) {
        // Generar las filas de la tabla con los detalles
        foreach ($detalles as $detalle) { ?>
            <tr>
               
                <td>
                    <input type="hidden" name="vart_cod[]" value="<?php echo htmlspecialchars($detalle['art_cod']); ?>">
                    <?php echo htmlspecialchars($detalle['art_descri']); ?>
                </td>
                
          
                <td>
                    <input type="hidden" name="vord_cant[]" value="<?php echo htmlspecialchars($detalle['pre_cant']); ?>">
                    <?php echo htmlspecialchars($detalle['pre_cant']); ?>
                </td>
                
              
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="3">No se encontraron detalles para este pedido.</td>
        </tr>
    <?php }
} else { ?>
    <tr>
        <td colspan="3">Debe seleccionar un pedido.</td>
    </tr>
    
<?php }
?>



