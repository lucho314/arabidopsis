<?php
include_once('lib/connect_mysql.php');
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];
 
if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
?>
<!DOCTYPE html>
<html lang="es">
 <head>
  <meta name="author" content="denker">
  <title> Restablecer contraseña </title>
  <link href="bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap-3.3.6/css/bootstrap-theme.min.css" rel="stylesheet">
 </head>
 
<body style="background-color: rgb(122, 161, 174);">

<div align="center" style="padding: 5px; margin-left: 5%; margin-right: 5%; background: #cccccc;">

    <br>

<table width="100%" height="50" align="center" cellpadding="5" cellspacing="0" border="0">

<tr>
    <td>
    <div class="panel panel-primary">
    <div class="panel-body">
            <table cellspacing="5px" cellpadding="5px" align="center" width="95%" style="background: #ffffff">
                <tr>
                    <td align="left" width="30%">
                      <img src="images/logo.png" width="400">
                    </td>
                    <td width="40%" align="right">
                      <div align="center"><strong><h3>Sistema de gesti&oacute;n de eventos "Arabidopsis"</h3></strong></div>
                    </td>
                    <td width="30%" align="left">
                      <p style="text-decoration: blink;">
                      <img src="images/tips.jpg" align="right">
                      <?php
                         $tip='Ingrese su nombre de usuario y contrase&ntilde;a';
                         echo $tip;

                      ?>

                      </p>
                    </td>
                </tr>
            </table>
    </div>
    </div>
    </td>
</tr>

<tr>
<td align="center">
    <div class="container" role="main">
      <div class="col-md-2"></div>
      <div class="col-md-8">
<?php
   $sql = " SELECT * FROM tblreseteopass WHERE token = '$token' ";
   $resultado = mysql_query($sql);
   if( mysql_affected_rows() > 0 ){
      $usuario = mysql_fetch_assoc($resultado);
      if( sha1( $usuario['idusuario'] === $idusuario ) ){
         if( $password1 === $password2 ){
            $sql = "UPDATE usuarios SET pass = '".md5($password1)."' WHERE id = ".$usuario['idusuario'];
            $resultado = mysql_query($sql);
            if($resultado){
               $sql = "DELETE FROM tblreseteopass WHERE token = '$token';";
               $resultado = mysql_query($sql);
?>
               <p class="alert alert-info"> La contraseña se actualizó con exito. </p>
               <a href="index.php">Iniciar sesion</a>
<?php
            }
            else{
?>
              <p class="alert alert-danger"> Ocurrió un error al actualizar la contraseña, intentalo más tarde </p>
              <a href="javascript:history.go(-1);">Atras</a>
<?php
            }
         }
         else{
?>
           <p class="alert alert-danger"> Las contraseñas no coinciden </p>
           <a href="javascript:history.go(-1);">Atras</a>
<?php
         }
      }
      else{
?>
        <p class="alert alert-danger"> El token no es válido </p>
<?php
      }
   }
   else{
?>
      <p class="alert alert-danger"> El token no es válido </p>
<?php
   }
?>
</div>
</div>
</td>
</tr>
</table>
</div>
<div class="col-md-2"></div>
</div> <!-- /container -->
<script src="js/jquery-1.11.1.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
else{
   header('Location:index.html');
}