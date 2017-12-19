<?php
include_once('html_sup_min.php');
include("scaffold.php");
//error_reporting(-1);


$id_evento = $_GET['id'];



?>
<h2>Detalle de evento registrado en agenda.</h2><br>

<?php
// Tomo los datos del cliente.
$cliente_id         = DevuelveValor($id_evento, 'cliente_id', 'agendas', 'id');
$razon_social_cl    = DevuelveValor($cliente_id, 'razon_social', 'clientes', 'id');
$cuit_cl            = DevuelveValor($cliente_id, 'cuit', 'clientes', 'id');
$domicilio_cliente  = DevuelveValor($cliente_id, 'domicilio', 'clientes', 'id');
$localidad_id       = DevuelveValor($cliente_id, 'localidad_id', 'clientes', 'id');
$localidad          = DevuelveValor($localidad_id, 'descripcion', 'localidads', 'id');

?>
<div style="width: 600px;">
<fieldset>
    <legend>
        Datos del cliente (si existe) - Id Cliente: <?php echo $cliente_id;?>
    </legend>
<br>
<strong>Raz&oacute;n Social: </strong><?php echo $razon_social_cl;?><br>
<strong>CUIT: </strong><?php echo $cuit_cl;?><br>
<strong>Domicilio: </strong><?php echo $domicilio_cliente;?><br>
<strong>Localidad: </strong><?php echo $localidad;?><br><br>
</fieldset>
<br>


<?php
// Tomo los datos del evento.
$descripcion        = DevuelveValor($id_evento, 'descripcion', 'agendas', 'id');
$titulo             = DevuelveValor($id_evento, 'titulo', 'agendas', 'id');
$fecha              = DevuelveValor($id_evento, 'fecha', 'agendas', 'id');
$hora               = DevuelveValor($id_evento, 'hora', 'agendas', 'id');
$observaciones      = DevuelveValor($id_evento, 'observaciones', 'agendas', 'id');

?>
<fieldset>
    <legend>
        Datos del evento ID: <?php echo $id_evento;?>
    </legend>
<br>

<strong>Evento: </strong><?php echo $titulo;?><br>
<strong>Descripcion: </strong><?php echo $descripcion;?><br>
<strong>Fecha y hora: </strong><?php echo $fecha." - ".$hora;?><br>
<strong>Observaciones: </strong><?php echo $observaciones;?><br>
<br>
<hr size="1"><br>
<a href="" onclick="window.close();">Cerrar ventana</a>
<br><br>
</div>
<?php


include_once('html_inf.php');
?>            
