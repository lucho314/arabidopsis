<?php

include_once('html_sup.php');
include("scaffold.php");

$maestro = $_POST['maestro_id'];


new Scaffold("noeditable","reparto_detalles",30);

if ($_POST['variablecontrolposnavegacion']!='new'){
?>
<br>

<br>

<form action="procesa_reparto.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="maestro_id" value="<?php echo $maestro;?>">

  <table width="400" cellspacing="0" border="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td align="center"><input type="submit" name="genera" class="boton_normal" value="Actualizar reparto"></td>
    </tr>
  </tbody>
</table>
</form>
<?php
}


include_once('html_inf.php');
?>
