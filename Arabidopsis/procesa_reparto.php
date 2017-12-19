<?php
ob_start();
$tip = '';

include_once('html_sup.php');

//tomo variables por POST
$id_rm 	 = $_POST['maestro_id'];
$submit  = $_POST['genera'];
echo 'Maestro id: '.$id_rm.'<br>';

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

//Completo el reparto maestro con todos los datos del detalle.

if ($submit == 'Actualizar reparto') {
	

//Tomo los datos del reparto maestro
$consulta_rm = "SELECT * FROM reparto_maestros WHERE id = $id_rm";
echo $consulta_rm.'<br>';
$resultado_rm = mysql_query($consulta_rm,$link);

while ($fila_rm = mysql_fetch_array($resultado_rm, MYSQL_BOTH)) {

$descripcion_rm 	= $fila_rm['descripcion'];
$empleado_id_rm		= $fila_rm['empleado_id'];
$fecha_rm		= $fila_rm['fecha'];
$cambio_rm		= $fila_rm['cambio'];
$total_a_cobrar_rm	= $fila_rm['total_a_cobrar'];
$dinero_ingresado_rm	= $fila_rm['dinero_ingresado'];
$desfasaje_rm		= $fila_rm['desfasaje'];
}

// Leo el valor total a cobrar de la factura correspondiente y lo agrego al reparto
// Debo recorrer los detalles de reparto e ir incrementando una variable.


//Tomo los datos del reparto detalle
$consulta_rd = "SELECT pedido_maestro_id FROM reparto_detalles WHERE reparto_maestro_id = $id_rm";
$resultado_rd = mysql_query($consulta_rd,$link);

while ($fila_rd = mysql_fetch_array($resultado_rd, MYSQL_BOTH)) {

$pedido_maestro_id_rd 	= $fila_rd['pedido_maestro_id'];
echo 'Pedido maestro id: '.$pedido_maestro_id_rd.'<br>';
//Tomo el total que corresponde a la venta de ese pedido.

	$consulta_fm = "SELECT total_venta FROM factura_maestros WHERE pedido_maestro_id = $pedido_maestro_id_rd";
	$resultado_fm = mysql_query($consulta_fm,$link);

	while ($fila_fm = mysql_fetch_array($resultado_fm, MYSQL_BOTH)) {

	$total_venta 	= $fila_fm['total_venta'];
	$cantidad_total = $cantidad_total + $total_venta;
	echo $cantidad_total.'<br>';
	}

}


//Actualizo los datos de la factura y del pedido.

$update_rm = "UPDATE reparto_maestros SET total_a_cobrar = $cantidad_total WHERE id = $id_rm";
$rupdate_rm = mysql_query($update_rm,$link);









//Muestro la factura.

$msg = "Se actualizaron correctamente los valores del reparto correspondiente.<br><br>";
header("Location: reparto_maestros.php?mensaje=$msg");

}

include_once('html_inf.php');
?>