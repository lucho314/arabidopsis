<?php
include_once('lib/funciones.php');
include_once 'variables.php';
session_name("Arabidopsis");
session_start();
if(isset($_FILES["archivo"]))
{
	$path = $_FILES['archivo']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$output_dir = "uploads\\";
	
	$descripcion = "Movimiento_".$_SESSION["movimiento_id"];
	$fecha=$_SESSION["fecha"];
	$nro_comprobante=$_SESSION["nro_comprobante"];
	$nro_factura=$_SESSION["nro_factura"];
	$fileName="$fecha-$nro_comprobante$nro_factura.$ext";
	$sql="INSERT INTO `archivos` (`id`, `nombre`,descripcion, `usuario_alta`, `usuario_modificacion`, `fecha_alta`, `fecha_modificacion`,visible_colaborador) VALUES (NULL, '$fileName','$descripcion',".$_SESSION['usuario_id']." , NULL, CURRENT_TIMESTAMP, NULL,0)";
		if(mysql_query($sql))
 	 	{
 	 		
	 		move_uploaded_file($_FILES["archivo"]["tmp_name"],$output_dir.$fileName);
	    	
    	}
    	else{
    		$ret['error']='Ocurrio un error al subir el archivo';
    	}
    unset(
		$_SESSION["movimiento_id"],
		$_SESSION["nro_comprobante"],
		$_SESSION["nro_factura"],
		$_SESSION["fecha"]
	);
     echo json_encode($ret);


}
else{

	$mysqli = new mysqli($Servidor, $Usuario, $Clave, $NombreDB);



if ($mysqli->connect_errno) {
    printf("Conexión fallida: %s\n", $mysqli->connect_error);
    exit();
}


$mysqli->begin_transaction();
$mysqli->autocommit(FALSE);
try {
	


$data = json_decode(file_get_contents('php://input'), true);

  $sql_movimiento="INSERT INTO `movimientos` (`descripcion`, `tipo_movimiento_id`, `concepto_movimiento_id`, `fecha`, `proveedor_id`, `monto_en_pesos`, `nro_comprobante_o_transaccion`, `nro_factura`, `observaciones`)
 VALUES (
 		'".$data['detalle']."',
 		2,
 		'".$data['concepto_id']."',
 		'".date_transform_usa($data['fecha'])."',
 		'".$data['proveedor_id']."',
 		'".$data['monto']."',
 		'".$data['nro_comprobante']."',
 		'".$data['nro_factura']."',
 		'".$data['observaciones']."'
)";

if(!$mysqli->query($sql_movimiento))
{
	 throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql_movimiento", $msqli->errno); 
}


$movimiento_id= $mysqli->insert_id;
$_SESSION["movimiento_id"]=$movimiento_id;
$_SESSION["nro_factura"]=$data['nro_factura'];
$_SESSION["fecha"]=$data['fecha'];

$_SESSION["nro_comprobante"]=$data['nro_comprobante'];
saveItems($data['items'],$movimiento_id,$mysqli);

foreach ($data["pagos"] as $value) {

	if($value['forma_pago']!="5")
	{
		$value['cuotas']="NULL";
		$value['cuota_uno']="NULL";
		$value['otras_cuotas']="NULL";

	}
	else
		$value['tipo_de_transaccion_id']=$value['tarjeta_id'];

	 $sql_pagos="INSERT INTO `pagos_realizados` (`movimiento_id`, `forma_de_pago_id`,tipo_de_transaccion_id, `monto`, `cantidad_cuotas`, `monto_cuota_uno`, `monto_demas_cuotas`,banco_id) 
		VALUES (
				$movimiento_id,
			".$value['forma_pago'].",
			".$value['tipo_de_transaccion_id'].",
			".$value['monto'].",
			".$value['cuotas'].",
			".$value['cuota_uno'].",
			".$value['otras_cuotas'].",
			".$value['banco_id']."
		)";

	if(!$mysqli->query($sql_pagos))
	{

		 throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql_pagos", $msqli->errno); 
	}
	$pagoid=$mysqli->insert_id;


	if($value['forma_pago']=="5")
	{
		$sql_tarjetas="INSERT INTO `pago_con_tarjeta` (`id`,`pago_realizado_id`, `tarjeta_id`, `monto`, `numero_cuota`)
				VALUES (NULL,$pagoid,".$value['tarjeta_id'].",".$value['cuota_uno'].",1)";
		for($i=1; $i<$value['cuotas']; $i++)
		{
			$sql_tarjetas.=",(NULL,$pagoid,".$value['tarjeta_id'].",".$value['otras_cuotas'].",".($i+1).")";
		}

		 if(!$mysqli->query($sql_tarjetas))
			{
				
				
				 throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql_tarjetas", $msqli->errno); 
				
			}
	}

}
	echo json_encode(['exito']);
	$mysqli->commit();

} catch (Exception $e) {
	 header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => $e->getMessage(), 'code' => 1337)));
	$mysqli->rollback();

}



$mysqli->close();

}





function saveItems($items,  $movimiento_id, $conn){
	foreach ($items as  $value) {
		 $sql="INSERT INTO `items` (`id`, `precio`, `cantidad`, `movimiento_id`,descripcion) 
			VALUES 
			(NULL, ".$value['precio'].", ".$value['cantidad'].", $movimiento_id, '".$value['descripcion']."')";
		 if(!$conn->query($sql))
			{
				 throw new Exception("MySQL error $conn->error <br> Query:<br> $sql", $conn->errno); 
				
			}
	}

}


?>




