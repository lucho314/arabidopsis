<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');

$respuesta = new stdClass();



$email=$_REQUEST['email'];

if($email!=''){


		$sql="select * from usuarios where email='$email'";

		$result=mysql_query($sql);

			if(mysql_affected_rows()==0){

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

				 $sql="INSERT INTO `usuarios` (`id`, `descripcion`, `usuario`, `pass`, `nivel_acceso`, `nombre`, `apellido`, `sexo`, `edad`, `domicilio`, `localidad`, `provincia`, `telefono`, `email`, `usuario_id`, `empresa_id`) "
				        . "VALUES (NULL, '$descripcion','$email','$pass', '2', NULL, NULL, NULL, NULL, '$domicilio', '$localidad', '$provincia', '$telefono', '$email', 1, 1);";
				mysql_query("delete from usuarios where email='".$email."'");
				$result=mysql_query($sql);

				if($result){
					$respuesta->mensaje = '<div class="alert alert-info"> Un correo ha sido enviado a su cuenta de email con las instrucciones para iniciar sesion, si no recibe el email dentro de las 24hs comuniquese con nosotros a <a href="mailto:info@impulsodeunanuevavida.org"> info@impulsodeunanuevavida.org </a> solicitando usuario y contraseña </div>';
					$link='http://'.$_SERVER["SERVER_NAME"]."/gestion/";
					$body = "<html>
				     <head>
				        <title>Alta de usuario</title>
				     </head>
				     <body>
				       <p>Le ponemos a disposicion un usuario y contraseña para que pueda acceder a nuestro sistema</p>
				       <p>
				         <strong>Usuario</strong>: $email<br>
				         <strong>contraseña</strong>: $password<br>
				         <strong>Ingreasar haciendo click</strong>: <a href='$link'> aqui </a>
				       </p>
				     </body>
				    </html>";
				    $subject="Alta de usuario";
				    include 'enviar_email.php';
				}
				 
			}
			else{
				$respuesta->mensaje = '<div class="alert alert-warning"> No existe una cuenta asociada a ese correo. </div>';
			 	
			}
	}
	else{
		$respuesta->mensaje = '<div class="alert alert-warning">Ya existe un usuario con ese email, si no se acurda su contraseña haga click en <a href="recuperar_contrasenia.html">"Resetear contrase&ntilde;a".</a> </div>';
	}
}
else
	   $respuesta->mensaje= "Debes introducir el email de la cuenta";
	 
echo json_encode( $respuesta );
