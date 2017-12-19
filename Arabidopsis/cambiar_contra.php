<?php

include_once('/../lib/connect_mysql.php');


$usuario = $_REQUEST['usuario'];
$nueva=$_REQUEST['nueva'];
$actual=$_REQUEST['actual'];
$repetir=$_REQUEST['repetir'];

$respuesta = new stdClass();

$sql='SELECT * FROM usuarios where id='.$usuario;

$data=mysql_query($sql);

$user=mysql_fetch_assoc($data);

if($user['pass']==md5($actual))
{

	if($nueva==$repetir)
	{
		$sql="UPDATE usuarios set pass='".md5($nueva)."' where id=".$usuario;
		if(mysql_query($sql))
		{
			 $respuesta->operacion =1;
		}
		else{
			$respuesta->operacion =0;
			$respuesta->mensaje='Ocurrio un error al modificar la contraseña intente mas tarde';	
		}
	}
	else{
			$respuesta->operacion =0;
			$respuesta->mensaje='Las contraseñas deben coincidir';

	}
}
else{

	$respuesta->operacion =0;
	$respuesta->mensaje='La contraseña actual es incorrecta';


}

 
 echo json_encode( $respuesta );


