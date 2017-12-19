<?php //
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');



?>
<div align="center" class="tituloprincipal">
<hr size="1">    
Resumen de caja diario. Elija la fecha.
<hr size="1">
<br>
</div>
<form name="form" action="resumen_de_caja_diario.php" method="POST">
<table align="center" width="300">
    <tr>
        <td align="right">Fecha:</td>
        <td align="left"><input type="text" name="fecha" class="calendario"></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" name="submit" value="Siguiente">
        </td>
    </tr>
</table>
 </form>
<br>
 

<?php
echo $msg;
include_once('html_inf.php');
?>