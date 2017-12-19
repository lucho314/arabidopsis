<?php
include_once('html_sup.php');
$mes		= LimpiarXSS($_POST['mes']);
$anio		= LimpiarXSS($_POST['anio']);
$empleado_id	= LimpiarXSS($_POST['empleado_id']);

$total = 0;

$descripcion_empleado = DevuelveValor($empleado_id,'descripcion','empleados','id');

echo '<div align="left">';
echo '<br><strong>Empleado: </strong>'.$descripcion_empleado;
echo '<br><strong>Mes: </strong>'.$mes;
echo '<br><strong>A&ntilde;o: </strong>'.$anio;
echo '<br>';
echo '</div>';

$sql = "SELECT pedido_maestro_id,fecha,monto FROM comisions WHERE empleado_id = $empleado_id AND MONTH(fecha) = $mes AND YEAR(fecha) = $anio ORDER BY fecha";

$resultado = mysql_query($sql,$link);

//Recorro el array y muestro el resultado.


echo "<table align='center' width='800' border='1'>";
echo "
<tr>
  <td align='center'>
   <strong>Id Pedido</strong>
  </td>
  <td align='center'>
   <strong>Fecha</strong>
  </td>
  <td align='center'>
   <strong>Comisi&oacute;n</strong>
  </td>
";

while ($fila = mysql_fetch_array($resultado, MYSQL_BOTH)) {

$pedido_maestro_id 	= $fila['pedido_maestro_id'];
$fecha			= $fila['fecha'];
$monto			= $fila['monto'];


echo "
<tr>
  <td align='center'>
   $pedido_maestro_id
  </td>
  <td align='center'>
   $fecha
  </td>
  <td align='center'>
   $monto
  </td>
";
$total = $total + $monto;
}

echo '</table><br><br><div align="center"><strong>Total: </strong>'.$total.'</div><br>';
?>
<script type="text/javascript">window.print();</script>
<?php

include_once('html_inf.php');
?>