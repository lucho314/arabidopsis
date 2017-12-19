<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$ventananueva = LimpiarXSS($_POST['ventananueva']);
?>
<head>
  <title>Gestion Fidunv</title>
  <meta name="author" content="Walter R. Elias">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--   <link type="text/css" rel="stylesheet" href="estilos.css"> -->
	<!--<link rel="stylesheet" href="menu.css">-->
	<!--<link rel="stylesheet" href="viejos/style.css">-->
        
        
        

        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.css">
        
        
      
        
        <!--AUTOCOMPLETAR-->
        <link href="css/select2.css" rel="stylesheet" />
        <script src="js/select2.min.js"></script>
        <!--FIN AUTOCOMPLETAR-->
        
        
        
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
	<script src="js/vanadium.js" type="text/javascript"></script>

	<link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<script src="js/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	jQuery(document).ready(function($) {
	$('a[rel*=facebox]').facebox({
		loadingImage : 'css/loading.gif',
		closeImage   : 'css/closelabel.png'
	})
	})
	</script>

	<script language="javascript">
	function eltooltip(algo)
	{
		var ejecuta = window.event;
		var x = ejecuta.x;
		var y = ejecuta.srcElement.offsetTop+ejecuta.srcElement.offsetHeight+10;
		var pos = tabla.style;
		tabla.innerHTML = '<table style="background-color:INFOBACKGROUND;font:8pt Arial;padding:3px 3px 3px 3px;border:1px solid INFOTEXT"><tr><td align=left>'+ algo +'</td></tr></table>';
		pos.posTop = y
		pos.posLeft = x;
		pos.visibility = '';
	}
	</script>



        
<!--SCRIPTS PARA CALENDARIO-->

	<!-- Set the viewport width to deevvice width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="css/eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="css/eventCalendar_theme_responsive.css">

<!--FIN SCRIPTS CALENDARIO-->
        
        
<script type="text/javascript">
  $('select').select2();
  
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});  


  
</script>


<!--LIBRERIAS SELECT HORA-->
  <script type="text/javascript" src="js/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />

<!--FIN LIBRERIAS SELECT HORA-->


  <script>
  $(function() {
      $( ".datepicker" ).datepicker({
              dateFormat:"dd-mm-yy"
          });
      });
      
  $(function() {
      $( ".selecthora" ).timepicker({ 'timeFormat': 'H:i' });
      });      
      
      
  </script>

        
        <!--FIN CALENDARIO SELECTOR DE FECHA-->

<!--VENTANAS EMERGENTES-->


<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

<!--FIN VENTANAS EMERGENTES-->

<!-- Datatable y estilos Agregados estilos y libreria datatable    F.C. -->
<script type="text/javascript" language="javascript" src="DataTables-1.10.12/media/js/jquery.dataTables.js">
</script>
<link rel="stylesheet" href="bootstrap-3.3.6/css/bootstrap.min.css">

        <script src="bootstrap-3.3.6/js/bootstrap.min.js" ></script>
<!-- Fin Datatable y estilos -->



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
                      <div align="center"><strong><h3>Sistema de gesti&oacute;n de eventos</h3></strong></div>
                    </td>
                    <td width="30%" align="left">
                      <p style="text-decoration: blink;">
                      <img src="images/tips.jpg" align="right">
                      <?php
                         $tip='Ingrese su nombre de usuario y contrase&ntilde;a';
                         echo $tip;

                      ?>

                      </p>
                      <a href="index.php">Iniciar secion</a>
                    </td>
                </tr>
            </table>
    </div>
    </div>
    </td>
</tr>

<tr>
<td align="center">
<br>    <font color="red"><strong><?=$_GET['mensaje']?></strong></font><br><br>
<div class="panel panel-primary" align="center" style="width: 500px;">
<div class="panel-body">
	
  <div class="panel panel-default">
    <div class="panel-heading"> Registrarse </div>
    <div class="panel-body">
     <div class="form-group">
      <form action="#">
	    <label class="control-label">Escribe el email asociado a un colaborador:</label>
	
	            <input name="email" type="emial" id="email"  placeholder="Ingrese su email" required="true" class="form-control">
	      
	</div>

	        <div class="col-sm-offset-3 col-sm-5">
            <button class="btn btn-primary btn-block" type="submit" name="Submit" id='aceptar' value="Registrar">Registrar</button>
           
        </div>
      </form>
  </div>

			 <div id="mensaje"></div>
	</div>
	</div>
<br><br><br>
</td></tr></table>
</div>


<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE8.js" type="text/javascript"></script>
<![endif]-->


</body>
</html>

<script type="text/javascript">
	 $(document).ready(function(){
    $("form").submit(function(event){
      event.preventDefault();
      $.ajax({
        url:'colaborador_usuario.php',
        type:'post',
        dataType:'json',
        data:$(this).serializeArray()
      }).done(function(respuesta){
        $("#mensaje").html(respuesta.mensaje);
        $("form").val('');
      });
    });
  });
</script>