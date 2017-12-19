<?php
include_once('html_sup.php');
include_once('lib/connect_mysql.php');
$dia_inicial = '01';
$mes_actual = Date('m');
$anio_actual = Date('Y');
$dia_actual = Date('d');
$inicio	= $dia_inicial.'-'.$mes_actual.'-'.$anio_actual;
$hoy	= $dia_actual.'-'.$mes_actual.'-'.$anio_actual;
?>

<form name="conexiones" method="POST" action="generar_listado.php">
<div align="center">
<h3>Per&iacute;odo: Desde <?php echo $inicio.' hasta '.$hoy;?></h3>
<input type="hidden" name="fecha_inicial" value="<?php echo $inicio;?>">
<input type="hidden" name="fecha_final" value="<?php echo $hoy;?>">
<br><br>
<table width="0" cellspacing="0" border="0" cellpadding="10" align="center">
  <tbody>
    <tr>
      <td align="right">Seleccione una cooperativa:</td>
      <td align="left">
    <select name="ente_id" id="ente_id">
        <option selected>Cooperativa:</option>
        <?php
        $sql = "SELECT e.id,e.descripcion
        	FROM ente_externos AS e
        	ORDER BY descripcion";
        $query2 = mysql_query($sql,$link);
        while($result_query2 = mysql_fetch_array($query2))
        echo "<option value='$result_query2[0]'>$result_query2[1]</option\n>";
        ?>
    </select>
      </td>
    </tr>
    <tr>
      <td align="right">Tipo de listado</td>
      <td>
    <select name="listado_id" id="listado_id">
        <option selected>Tipo de listado:</option>
        <?php
        $sql = "SELECT id,descripcion
        	FROM listados
        	ORDER BY descripcion";
        $query2 = mysql_query($sql,$link);
        while($result_query2 = mysql_fetch_array($query2))
        echo "<option value='$result_query2[0]'>$result_query2[1]</option\n>";
        ?>
    </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td align="right"><input type="submit" name="submit" value="Siguiente->"></td>
    </tr>
  </tbody>
</table>

</div>
</form>
<?php

include_once('html_inf.php');
?>