<?php
include_once('lib/connect_mysql.php');
$token = $_GET['token'];
$idusuario = $_GET['idusuario'];
 
 
$sql = "SELECT * FROM tblreseteopass WHERE token = '$token'";

$resultado = mysql_query($sql);
 
if( mysql_affected_rows()> 0 ){
   $usuario = mysql_fetch_assoc($resultado);
   if( sha1($usuario['idusuario']) == $idusuario ){
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
   <div class="col-md-4"></div>
   <div class="col-md-4">
    <form action="cambiarpassword.php" method="post">
     <div class="panel panel-default">
      <div class="panel-heading"> Restaurar contraseña </div>
      <div class="panel-body">
       <p></p>
       <div class="form-group">
        <label for="password"> Nueva contraseña </label>
        <input type="password" class="form-control" name="password1" required>
       </div>
       <div class="form-group">
        <label for="password2"> Confirmar contraseña </label>
        <input type="password" class="form-control" name="password2" required>
       </div>
       <input type="hidden" name="token" value="<?php echo $token ?>">
       <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
       <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Recuperar contraseña" >
       </div>
      </div>
     </div>
    </form>
   </div>
  <div class="col-md-4"></div>
  </div> <!-- /container -->
 </td>
</tr>
</table>
</div>

  <script src="js/jquery-1.10.2.js"></script>
  <script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
 </body>
</html>
<?php
   }
   else{
     header('Location:index.html');
   }
 }
 else{
     header('Location:index.html');
 }
?>