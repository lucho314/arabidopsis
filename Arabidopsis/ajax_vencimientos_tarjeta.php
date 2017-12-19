<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
if(isset($_POST["fecha_vencimiento"]))
{

	foreach (array_filter($_POST["fecha_vencimiento"]) as $key => $value) {
		echo $sql="UPDATE tarjeta_de_creditos SET fecha_vencimiento='".date_transform_usa($value)."' WHERE id=".$key;
		mysql_query($sql);
	}
}
elseif(isset($_POST["postergar"])){
	session_name($_POST["session"]);
	session_start();
	$_SESSION["postergar"]=1;
	print_r($_SESSION);
}

?>