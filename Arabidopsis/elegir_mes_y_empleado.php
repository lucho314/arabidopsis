<?php

include_once('html_sup.php');
include("scaffold.php");

?>

<form action="listar_comision.php" method="POST" enctype="multipart/form-data" target="ventanaForm" onsubmit="window.open('', 'ventanaForm', 'width=1024,height=400,top=300,left=100,scrollbars=yes');">

<input type="hidden" name="maestro_id" value="<?php echo $maestro;?>">

  <table width="500" cellspacing="0" border="0" cellpadding="0" align="center">
  <tbody>
    <tr>
	<td align="right">
	Empleado: 
	</td>
	<td align="left">
                <select name="empleado_id" id="empleado_id"> 
                  <option selected value=''>Elija un empleado</option>  <!--pone valor por defecto-->
                  <?
			$sql = "SELECT id, apellido, nombre
				FROM empleados
				ORDER BY apellido";
			$query = mysql_query($sql);
			while($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
			echo "<option value='$result_query[0]'>$result_query[0] - $result_query[1], $result_query[2]</option\n>";//muestra resultado de la consulta
		  ?>
                </select>
	</td>
    </tr>
    <tr>
    <tr>
	<td align="right">
	Mes:
	</td>
	<td align="left">
		<select name="mes">
			<option select value=''>Elija un mes</option>
			<option select value='01'>Enero</option>
			<option select value='02'>Febrero</option>
			<option select value='03'>Marzo</option>
			<option select value='04'>Abril</option>
			<option select value='05'>Mayo</option>
			<option select value='06'>Junio</option>
			<option select value='07'>Julio</option>
			<option select value='08'>Agosto</option>
			<option select value='09'>Setiembre</option>
			<option select value='10'>Octubre</option>
			<option select value='11'>Noviembre</option>
			<option select value='12'>Diciembre</option>
		</select>
	</td>
    </tr>
    <tr>
	<td align="right">
	A&ntilde;o:
	</td>
	<td align="left">
		<input type="text" name="anio"> Formato: aaaa
	</td>
    </tr>    
    <tr>
      <td align="right" colspan="2"><input type="submit" name="genera" class="boton_normal" value="Genera listado"></td>
    </tr>
  </tbody>
</table>
<input type="hidden" name="ventananueva" value="si">
</form>

<br><br>

<?php



new Scaffold("noeditable","comisions",30,array('descripcion','empleado_id','pedido_maestro_id','fecha','monto'));


include_once('html_inf.php');
?>
