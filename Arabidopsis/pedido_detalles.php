<?php
$tip = 'La opci&oacute;n "Genera pedido" tambi&eacute;n debe usarse para actualizar un pedido ante una modificaci&oacute;n';

include_once('html_sup.php');
include("scaffold.php");
$maestro = $_POST['maestro_id'];
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    var indice = document.crear.producto_id.selectedIndex;
    var valor  = document.crear.producto_id.options[indice].value;

    descripcion = valor;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
<?php
new Scaffold("noeditable","pedido_detalles",30);

if ($_POST['variablecontrolposnavegacion']!='new'){
?>
<br>

<br>

<form action="procesa_pedido.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="maestro_id" value="<?php echo $maestro;?>">

  <table width="400" cellspacing="0" border="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td align="center"><a href="pedido_maestros.php"><input type="button" class="boton_normal" value="<- Volver a maestro" title="Genera o actualiza" alt="Genera o actualiza"></a></td>
      <td align="center"><input type="submit" name="genera" class="boton_normal" value="Genera factura" onclick="return confirm('Una vez generada la factura, no podr&aacute; agregar m&aacute;s productos al pedido. ');"></td>
      <td align="center"><input type="submit" name="genera" class="boton_normal" value="Genera remito" onclick="return confirm('Una vez generado el remito, no podr&aacute; agregar m&aacute;s productos al pedido. ');"></td>
      <td align="center"><input type="submit" name="genera" class="boton_normal" value="Genera pedido" onclick="return confirm('Al guardar el pedido se generan autom&aacute;ticamente las comisiones para el empleado. ATENCION: no se guarda comprobante (factura o remito) en el sistema.');"></td>
      <td align="center"><input type="submit" name="genera" class="boton_alerta" value="Vaciar pedido" onclick="return confirm('Se borrar&aacute;n todos los registros de este pedido. Est&aacute; seguro?');"></td>
    </tr>
  </tbody>
</table>
</form>
<?php
}
include_once('html_inf.php');
?>