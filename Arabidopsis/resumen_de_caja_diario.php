<?php //
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');

//Tomo la fecha:
$fecha = $_POST['fecha'];
$anio  = date('Y');
$mes   = date('m');
$dia   = date('d');

//Tomo el saldo del día anterior.
$fecha_anterior = new DateTime($fecha);
$fecha_anterior->sub(new DateInterval('P1D'));
$fecha_anterior = $fecha_anterior->format('Y-m-d');


//Tomo los datos de la base de datos correspondientes al día de la fecha
$consulta  = "SELECT * FROM cajas WHERE fecha = '$fecha' ORDER BY tipo_movimiento_id AND tipo_transaccion_id";

$resultado = mysql_query($consulta);



?>
<div align="center" class="tituloprincipal">
<hr size="1">    
Resumen de caja diario correspondiente al <?php echo $dia;?> del mes <?php echo $mes;?> de <?php echo $anio;?>
<hr size="1">
<br>
</div>
<table align="center" width="300">
    <tr>
        <td align="right">Fecha <strong>anterior</strong>:</td>
        <td align="left"><?php echo $fecha_anterior;?></td>
    </tr>
    <tr>
        <td align="right">Saldo <strong>anterior</strong> en pesos:</td>
        <td align="left"><?php echo $fecha_anterior;?></td>
    </tr>    
    <tr>
        <td align="right">Saldo <strong>anterior</strong> en dolares:</td>
        <td align="left"><?php echo $fecha_anterior;?></td>
    </tr> 
</table>
 
<br>
 

<table>
    <thead>
        <th>Descripcion</th>
        <th>Pesos</th>
        <th>Dolares</th>
        <th>Cliente</th>
        <th>Tipo de movimiento</th>
        <th>Tipo de transaccion</th>        
    </thead>
<!--Tabla en la que muestro los datos correspondientes a la caja de la fecha-->
<?php
while ($fila = mysql_fetch_array($resultado, MYSQL_BOTH)) {

$descripcion            = $fila['descripcion'];
$pesos			= $fila['pesos'];
$dolares		= $fila['dolares'];
$cliente            = DevuelveValor($fila['cliente_id'], 'descripcion', 'clientes', 'id');
$tipo_movimiento    = DevuelveValor($fila['tipo_movimiento_id'], 'descripcion', 'tipo_movimientos', 'id');
$tipo_transaccion   = DevuelveValor($fila['tipo_transaccion_id'], 'descripcion', 'tipo_transaccions', 'id');

echo "
<tr>
  <td align='center'>
   $descripcion
  </td>
  <td align='center'>
   $pesos
  </td>
  <td align='center'>
   $dolares
  </td>
  <td align='center'>
   $cliente
  </td>
  <td align='center'>
   $tipo_movimiento
  </td>
  <td align='center'>
   $tipo_transaccion
  </td>
</tr>
";

if ($fila['tipo_movimiento_id']==1) {
    $entrada_pesos = $entrada_pesos + $pesos;
    $entrada_dolares = $entrada_dolares + $dolares;
}else{
    $salida_pesos = $salida_pesos + $pesos;
    $salida_dolares = $salida_dolares + $dolares;
}

}
?>
</table>
<br>
Total entrada pesos: <?php echo $entrada_pesos;?><br>
Total entrada dolares: <?php echo $entrada_dolares;?><br>
Total salida pesos: <?php echo $salida_pesos;?><br>
Total salida dolares: <?php echo $salida_dolares;?><br>
<?php
echo $msg;
include_once('html_inf.php');
?>