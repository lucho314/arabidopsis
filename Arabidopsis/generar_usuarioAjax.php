<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');

$respuesta = new stdClass();



include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');

$respuesta = new stdClass();



$email=$_REQUEST['email'];

if($email!=''){


	

			$sql="select * from colaboradors where email='$email'";

			$result=mysql_query($sql);


				if(mysql_affected_rows()>0){

					$datos=mysql_fetch_assoc($result);


					$password=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_?.:;=-+%{}[]"), 0, 8);

					$pass=  md5($password);
					$localidad= DevuelveValor($datos['localidad_id'], 'descripcion', 'localidads', 'id');
					$provincia_id = DevuelveValor($datos['localidad_id'], 'provincia_id', 'localidads', 'id');
					$provincia=DevuelveValor($provincia_id, 'descripcion', 'provincias', 'id');
					$descripcion='colaborador-'.$datos['nombre'].' '.$datos['apellido'];
					$domicilio=$datos['domicilio'];
					$telefono=$datos['telefono'];
					mysql_query("delete from usuarios where email='".$email."'");
				  $sql="INSERT INTO `usuarios` (`id`,activo, `descripcion`, `usuario`, `pass`, `nivel_acceso`, `nombre`, `apellido`, `sexo`, `edad`, `domicilio`, `localidad`, `provincia`, `telefono`, `email`, `usuario_id`, `empresa_id`) "
				        . "VALUES (NULL, 1,'$descripcion','$email','$pass', '2', NULL, NULL, NULL, NULL, '$domicilio', '$localidad', '$provincia', '$telefono', '$email', 1, 1)";
				$result=mysql_query($sql);

				$respuesta->accion=1;
				$respuesta->pass=$password;
				$respuesta->colaborador=$datos['nombre'].' '.$datos['apellido'];;
				$respuesta->email=$email;



		
		}
		else{

			$respuesta->accion=0;
			$respuesta->erro='problemas al recuperar el colaborador';
		}
	}
	else{

			$respuesta->accion=0;
			$respuesta->erro='no se recibio';

	}


	echo json_encode( $respuesta );