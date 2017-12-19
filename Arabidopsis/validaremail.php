
<?php
include_once('lib/connect_mysql.php');




$email = $_REQUEST['email'];

 
$respuesta = new stdClass();
 
if( $email != "" ){
   $sql = " SELECT * FROM usuarios WHERE email = '$email' ";
   $resultado = mysql_query($sql);
   if(mysql_affected_rows() > 0){
      $usuario = mysql_fetch_assoc($resultado);
      $linkTemporal = generarLinkTemporal( $usuario['id'], $usuario['usuario'] );
      if($linkTemporal){
        enviarEmail( $email, $linkTemporal );
        $respuesta->mensaje = '<div class="alert alert-info"> Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contrase&ntilde;a, si no recibe el email dentro de las 24hs comuniquese con nosotros a <a href="mailto:info@impulsodeunanuevavida.org"> info@impulsodeunanuevavida.org </a> solicitando el reseteo de su cuenta</div>';
      }
   }
   else
      $respuesta->mensaje = '<div class="alert alert-warning"> No existe una cuenta asociada a ese correo. </div>';
}
else
   $respuesta->mensaje= "Debes introducir el email de la cuenta";
 echo json_encode( $respuesta );




function generarLinkTemporal($idusuario, $username){
   // Se genera una cadena para validar el cambio de contraseña
   $cadena = $idusuario.$username.rand(1,9999999).date('Y-m-d');
   $token = sha1($cadena);
 
   // Se inserta el registro en la tabla tblreseteopass
   $sql = "INSERT INTO tblreseteopass (idusuario, username, token, creado) VALUES($idusuario,'$username','$token',NOW())
     ON DUPLICATE KEY UPDATE token=token,idusuario=idusuario,username=username, creado=creado
   ";
   mysql_query("DELETE FROM tblreseteopass WHERE idusuario=$idusuario");
   $resultado = mysql_query($sql);
   if($resultado){
      // Se devuelve el link que se enviara al usuario
      $enlace = $_SERVER["SERVER_NAME"].'/gestion/restablecer.php?idusuario='.sha1($idusuario).'&token='.$token;
      return $enlace;
   }
   else
      return FALSE;
}
 
function enviarEmail( $email, $link ){
 $body = '<html>
     <head>
        <title>Restablece tu contraseña</title>
     </head>
     <body>
       <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
       <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
       <p>
         <strong>Enlace para restablecer tu contraseña</strong><br>
         <a href="http://'.$link.'"> Restablecer contraseña </a>
       </p>
     </body>
    </html>';

$subject = "Recuperar contraseña";
 
   include 'enviar_email.php';
}