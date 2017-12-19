<?php
ob_start();
$tip = '';

include_once('html_sup.php');

//tomo variables por POST
$id_pm 	 = $_POST['maestro_id'];
$submit  = $_POST['genera'];
echo "<strong>$submit</strong>";
//inicializo variables locales
$costo_total 		= 0;
$precio_sin_iva 	= 0;
$monto_iva 		= 0;
$precio_con_iva 	= 0;
$iva21_acumulado 	= 0;
$iva105_acumulado 	= 0;
$subtotal 		= 0;
$total_venta 		= 0;
$cantidad_total		= 0;




################################ GENERA FACTURA ##########################################
//Completo el pedido maestro con todos los datos del detalle.

if ($submit == 'Genera factura') {
//Tomo los datos del pedido maestro y los paso a factura maestro
$consulta_pm = "SELECT * FROM pedido_maestros WHERE id = $id_pm";
$resultado_pm = mysql_query($consulta_pm,$link);

while ($fila_pm = mysql_fetch_array($resultado_pm, MYSQL_BOTH)) {

$descripcion_pm 	= $fila_pm['descripcion'];
$cliente_id_pm		= $fila_pm['cliente_id'];
$empleado_id_pm		= $fila_pm['empleado_id'];
$fecha_pm		= $fila_pm['fecha'];
$hora_pm		= $fila_pm['hora'];


}



//En la factura debo guardar el número de pedido, que será lo que uso para verificar si ese pedido no ha sido facturado antes. 

$vconsulta_fm  = "SELECT pedido_maestro_id FROM factura_maestros WHERE pedido_maestro_id = $id_pm";
$vresultado_fm = mysql_query($vconsulta_fm);

while ($vfila_fm = mysql_fetch_array($vresultado_fm, MYSQL_BOTH)) {
$verifica_fm = $vfila_fm[0];
}

if (empty($verifica_fm)) {


//Creo factura maestro en función de los datos del pedido. El número de factura no tiene porque ser el mismo del pedido por lo que lo debo generar en función de los números almacenados en la base de datos.

$consulta_fm = "SELECT MAX(descripcion) AS descripcion FROM factura_maestros";
$resultado_fm = mysql_query($consulta_fm,$link);

while($fila_fm = mysql_fetch_array($resultado_fm, MYSQL_BOTH)){
$descripcion_fm = $fila_fm["descripcion"];
}

if (empty($descripcion_fm)) $descripcion_fm = 0;
$descripcion_fm = $descripcion_fm + 1;

$insert_fm = "INSERT INTO factura_maestros (`id`, `descripcion`, `cliente_id`, `pedido_maestro_id`, `fecha`, `iva21`, `iva105`, `total_iva`, `subtotal`, `total_venta`,`nro_pedido`,`nro_remito`) VALUES (NULL, '$descripcion_fm',$cliente_id_pm,$id_pm,'$fecha_pm', NULL, NULL, NULL, NULL, NULL,'$descripcion_pm',NULL)";

$rinsert_fm = mysql_query($insert_fm,$link);

$id_fm 		     = DevuelveValor($descripcion_fm,'id','factura_maestros','descripcion');
$nombre_cl 	     = DevuelveValor($cliente_id_pm,'nombre','clientes','id');
$apellido_cl 	     = DevuelveValor($cliente_id_pm,'apellido','clientes','id');
$razon_social_cl     = DevuelveValor($cliente_id_pm,'razon_social','clientes','id');
$cuit_cl 	     = DevuelveValor($cliente_id_pm,'cuit','clientes','id');
$condicion_iva_id_cl = DevuelveValor($cliente_id_pm,'condicion_iva_id','clientes','id');
$condicion_iva_cl    = DevuelveValor($condicion_iva_id_cl,'descripcion','condicion_ivas','id');

//Muestro la información sobre el pedido:
echo "
<div align='left'>
<strong>Nombre y apellido:</strong> $nombre_cl $apellido_cl <br>
<strong>Raz&oacute;n social:</strong> $razon_social_cl <br>
<strong>CUIT:</strong> $cuit_cl </br>
<strong>Condici&oacute;n IVA:</strong> $condicion_iva_cl <br>
</div><br>
";

//Tomo los datos de pedido detalle y los paso a factura detalle
$consulta_pd = "SELECT * FROM pedido_detalles WHERE pedido_maestro_id = $id_pm";
$resultado_pd = mysql_query($consulta_pd,$link);

echo "<table align='center' width='800' border='1'>";
echo "
<tr>
  <td align='center'>
   <strong>Cantidad</strong>
  </td>
  <td align='center'>
   <strong>Descripcion</strong>
  </td>
  <td align='center'>
   <strong>Precio unitario</strong>
  </td>
  <td align='center'>
   <strong>Precio de venta</strong>
  </td>
";

while ($fila_pd = mysql_fetch_array($resultado_pd, MYSQL_BOTH)) {

$descripcion_pd 	= $fila_pd['descripcion'];
$producto_id_pd		= $fila_pd['producto_id'];
$cantidad_pd		= $fila_pd['cantidad'];

$insert_fd = "INSERT INTO factura_detalles (`id`, `descripcion`, `producto_id`, `factura_maestro_id`,`cantidad`) VALUES (NULL, '$descripcion_pd',$producto_id_pd,$id_fm,'$cantidad_pd')";

$rinsert_fd = mysql_query($insert_fd,$link);

//comisión del empleado
$comision_em = DevuelveValor($empleado_id_pm,'comision','empleados','id');
echo $comision;


//Calculo los subtotales en función de los datos de cada producto (según IVA y margen)

$consulta_pr = "SELECT nombre, costo, margen, iva, disponibles FROM productos WHERE id = $producto_id_pd";
$resultado_pr = mysql_query($consulta_pr,$link);

while ($fila_pr = mysql_fetch_array($resultado_pr, MYSQL_BOTH)) {
$nombre		= $fila_pr['nombre'];
$costo		= $fila_pr['costo'];
$margen		= $fila_pr['margen'];
$iva		= $fila_pr['iva'];
$disponibles	= $fila_pr['disponibles'];
}


//Resto la cantidad del stock disponible o devuelvo un mensaje si no alcanza.
$resto = $disponibles - $cantidad_pd;
if (($resto <= 10.00) AND ($disponibles != $cantidad_pd)) {
Header ("Location: pedido_maestros.php?msg=NO HAY STOCK SUFICIENTE PARA EL PRODUCTO $nombre. QUEDAN $disponibles DISPONIBLES. MODIFIQUE EL DETALLE DEL PEDIDO.");
}else{
$disponibles = $disponibles - $cantidad_pd;
$actualiza_disponibles = mysql_query("UPDATE productos SET disponibles = $disponibles WHERE id = $producto_id_pd",$link);
echo '<script type="text/javascript">alert("No quedan m&aacute;s productos disponibles de art&iacute;culo '.$nombre.'")</script>';
}


//Calculo los valores totales
$costo_total = $costo * $cantidad_pd;
$precio_sin_iva = ($costo_total * $margen/100) + $costo_total;
$monto_iva = ($costo_total * $iva/100);
$precio_con_iva = $precio_sin_iva + $monto_iva;
$precio_unitario = $precio_con_iva / $cantidad_pd;
if ($iva = 21) $iva21_acumulado = $iva21_acumulado + $monto_iva;
elseif ($iva = 10.5) $iva105_acumulado = $iva105_acumulado + $monto_iva;
$subtotal = $subtotal + $costo_total;
$total_venta = $total_venta + $precio_con_iva;
$cantidad_total = $cantidad_total + $cantidad_pd;


// Comisión en pesos
$monto_comision = ($comision_em * $total_venta)/100;
$fecha_actual = Date('Y-m-d');
$descripcion_comision = DevuelveValor($empleado_id_pm,'apellido','empleados','id');

//Verifico si la comisión por esa venta está o no asignada a ese empleado. Si no está, la inserto. Sino, la actualizo.
$existe_comision = DevuelveValor($id_pm,'pedido_maestro_id','comisions','pedido_maestro_id');

if (empty($existe_comision)) {
//Guardo la comisión en la tabla
$insert_comision = "INSERT INTO comisions (`id`,`descripcion`,`empleado_id`,`pedido_maestro_id`,`fecha`,`monto`) VALUES ('','$descripcion_comision',$empleado_id_pm,$id_pm,'$fecha_actual',$monto_comision)";
// echo $insert_comision;
$rinsert_comision = mysql_query($insert_comision,$link);
}else{
$update_comision = "UPDATE comisions SET fecha = '$fecha_actual',monto = $monto_comision WHERE pedido_maestro_id = $id_pm";
// echo $update_comision;
$rupdate_comision = mysql_query($update_comision,$link);

}




echo "
<tr>
  <td align='center'>
   $cantidad_pd
  </td>
  <td>
   $nombre
  </td>
  <td align='center'>
   $precio_unitario
  </td>
  <td align='center'>
   $precio_con_iva
  </td>
";

}

echo "</table><br><br>";

//Actualizo los datos de la factura y del pedido.
$total_iva = $iva21_acumulado + $iva105_acumulado;
$update_fm = "UPDATE factura_maestros SET iva21 = $iva21_acumulado, iva105 = $iva105_acumulado, total_iva = $total_iva, subtotal = $subtotal, total_venta = $total_venta WHERE id = $id_fm";
$rupdate_fm = mysql_query($update_fm,$link);

$update_pm = "UPDATE pedido_maestros SET cantidad_productos = $cantidad_total, total_en_pesos = $total_venta WHERE id = $id_pm";

$rupdate_pm = mysql_query($update_pm,$link);



//Muestro la factura.

echo "La factura <strong>n&uacute;mero $descripcion_fm</strong> correspondiente al pedido <strong>n&uacute;mero $descripcion_pm</strong> fue generada correctamente. Si desea imprimir, presione el siguiente bot&oacute;n.<br><br>";

} //fin if factura existe
else

{

$msg = "La factura correspondiente al pedido <strong>numero $descripcion_pm</strong> ya fue emitida previamente.<br><br>";

header("Location: pedido_maestros.php?mensaje=$msg");
}

}
########################### GENERA REMITO ##############################
elseif ($submit == 'Genera remito') {
//Tomo los datos del pedido maestro y los paso a remito maestro
echo '<br><br>NO IMPLEMENTADO';
//Tomo los datos de pedido detalle y los paso a remito detalle

//Muestro el remito.

}
############################ GENERA ORDEN ##############################
elseif ($submit == 'Genera pedido') {


//Tomo los datos del pedido maestro
$consulta_pm = "SELECT * FROM pedido_maestros WHERE id = $id_pm";
$resultado_pm = mysql_query($consulta_pm,$link);



while ($fila_pm = mysql_fetch_array($resultado_pm, MYSQL_BOTH)) {

$descripcion_pm 	= $fila_pm['descripcion'];
$cliente_id_pm		= $fila_pm['cliente_id'];
$empleado_id_pm		= $fila_pm['empleado_id'];
$fecha_pm		= $fila_pm['fecha'];
$hora_pm		= $fila_pm['hora'];


}

//comisión del empleado
$comision_em = DevuelveValor($empleado_id_pm,'comision','empleados','id');
echo $comision_em;

//recorro el detalle de pedidos para calcular los totales
$consulta_pd = "SELECT * FROM pedido_detalles WHERE pedido_maestro_id = $id_pm";
$resultado_pd = mysql_query($consulta_pd,$link);

while ($fila_pd = mysql_fetch_array($resultado_pd, MYSQL_BOTH)) {

$descripcion_pd 	= $fila_pd['descripcion'];
$producto_id_pd		= $fila_pd['producto_id'];
$cantidad_pd		= $fila_pd['cantidad'];

echo 'Producto: '.$producto_id_pd.'<br>';
echo 'Descripcion: '.$descripcion_pd.'<br>';
echo 'Cantidad: '.$cantidad_pd.'<br>';

//Calculo los subtotales en función de los datos de cada producto (según IVA y margen)

$consulta_pr = "SELECT nombre, costo, margen, iva, disponibles FROM productos WHERE id = $producto_id_pd";
$resultado_pr = mysql_query($consulta_pr,$link);

while ($fila_pr = mysql_fetch_array($resultado_pr, MYSQL_BOTH)) {
$nombre		= $fila_pr['nombre'];
$costo		= $fila_pr['costo'];
$margen		= $fila_pr['margen'];
$iva		= $fila_pr['iva'];
$disponibles	= $fila_pr['disponibles'];
}


//Resto la cantidad del stock disponible o devuelvo un mensaje si no alcanza.
$resto = $disponibles - $cantidad_pd;
echo 'Cantidad: '.$cantidad;
echo 'Disponibles: '.$disponibles;
echo 'Resto: '.$resto;
echo '<br>';
if (($resto <= 10.00) AND ($disponibles != $cantidad_pd)) {
Header ("Location: pedido_maestros.php?mensaje=NO HAY STOCK SUFICIENTE PARA EL PRODUCTO <strong>$nombre</strong>. QUEDAN <strong>$disponibles</strong> DISPONIBLES. MODIFIQUE EL DETALLE DEL PEDIDO.<br><br>");
}else{
$disponibles = $disponibles - $cantidad_pd;
$actualiza_disponibles = mysql_query("UPDATE productos SET disponibles = $disponibles WHERE id = $producto_id_pd",$link);
$msg = "No quedan m&aacute;s productos disponibles de art&iacute;culo '.$nombre.'<br><br>";
}


//Calculo los valores totales
$costo_total = $costo * $cantidad_pd;
$precio_sin_iva = ($costo_total * $margen/100) + $costo_total;
$monto_iva = ($costo_total * $iva/100);
$precio_con_iva = $precio_sin_iva + $monto_iva;
$precio_unitario = $precio_con_iva / $cantidad_pd;
if ($iva = 21) $iva21_acumulado = $iva21_acumulado + $monto_iva;
elseif ($iva = 10.5) $iva105_acumulado = $iva105_acumulado + $monto_iva;
$subtotal = $subtotal + $costo_total;
$total_venta = $total_venta + $precio_con_iva;
$cantidad_total = $cantidad_total + $cantidad_pd;
}

// Comisión en pesos
$monto_comision = ($comision_em * $total_venta)/100;
$fecha_actual = Date('Y-m-d');
$descripcion_comision = DevuelveValor($empleado_id_pm,'apellido','empleados','id');

//Verifico si la comisión por esa venta está o no asignada a ese empleado. Si no está, la inserto. Sino, la actualizo.
$existe_comision = DevuelveValor($id_pm,'pedido_maestro_id','comisions','pedido_maestro_id');

if (empty($existe_comision)) {
//Guardo la comisión en la tabla
$insert_comision = "INSERT INTO comisions (`id`,`descripcion`,`empleado_id`,`pedido_maestro_id`,`fecha`,`monto`) VALUES ('','$descripcion_comision',$empleado_id_pm,$id_pm,'$fecha_actual',$monto_comision)";
// echo $insert_comision;
$rinsert_comision = mysql_query($insert_comision,$link);
}else{
$update_comision = "UPDATE comisions SET fecha = '$fecha_actual',monto = $monto_comision WHERE pedido_maestro_id = $id_pm";
// echo $update_comision;
$rupdate_comision = mysql_query($update_comision,$link);

}


//Actualizo los datos del pedido.
$total_iva = $iva21_acumulado + $iva105_acumulado;

$update_pm = "UPDATE pedido_maestros SET cantidad_productos = $cantidad_total, total_en_pesos = $total_venta WHERE id = $id_pm";
$rupdate_pm = mysql_query($update_pm,$link);

echo $update_pm;

//Muestro la factura.

$msg .= "Se generaron correctamente los datos del pedido..<br><br>";

header("Location: pedido_maestros.php?mensaje=$msg");
}



############################ VACIAR PEDIDO ################################

elseif ($submit == 'Vaciar pedido') {

$consulta_pd = "SELECT producto_id,cantidad FROM pedido_detalles WHERE pedido_maestro_id = $id_pm";
$resultado_pd = mysql_query($consulta_pd,$link);

while ($fila_pd = mysql_fetch_array($resultado_pd, MYSQL_BOTH)) {

	$producto_id = $fila_pd['producto_id'];
	$cantidad    = $fila_pd['cantidad'];

	$disponibles = DevuelveValor($producto_id,'disponibles','productos','id');

	$disponibles = $disponibles + $cantidad;

	$consulta_pr = "UPDATE productos SET disponibles = $disponibles WHERE id = $producto_id";
	$resultado_pr = mysql_query($consulta_pr,$link);


}

//Borro los detalles del pedido
$delete_pd = "DELETE FROM `pedido_detalles` WHERE pedido_maestro_id = $id_pm";
echo $delete_pd;

//borro los detalles del reparto asociado a ese pedido
$delete_rd = "DELETE FROM `reparto_detalles` WHERE pedido_maestro_id = $id_pm";
$rdelete_rd = mysql_query($delete_rd,$link);


$rdelete_pd = mysql_query($delete_pd,$link);
$update_pm = "UPDATE pedido_maestros SET cantidad_productos = 0, total_en_pesos = 0 WHERE id = $id_pm";
$rupdate_pm = mysql_query($update_pm,$link);

//Borro la comisión para este pedido
$delete_cc = "DELETE FROM `comisions` WHERE pedido_maestro_id = $id_pm";
$rdelete_cc = mysql_query($delete_cc,$link);

$msg = "El pedido fue vaciado correctamente.<br><br>";
header("Location: pedido_maestros.php?mensaje=$msg");

}
?>
<?php

include_once('html_inf.php');
?>