<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");


//Debo generar el nuevo numero de factura para poner en la descripcion.



$sql = "SELECT MAX(descripcion) AS descripcion FROM pedido_maestros";

$query = mysql_query($sql,$link);

while($fila = mysql_fetch_array($query, MYSQL_BOTH)){
$descripcion = $fila["descripcion"];
}

if (empty($descripcion)) $descripcion = 0;
$descripcion = $descripcion + 1;

?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

	descripcion = <?php echo $descripcion?>;

	document.getElementById('descripcion').value=descripcion;
	document.forms.crear.submit();
}
</script>
<?php
echo $msg;
new Scaffold("noeditable","pedido_maestros",30,array('descripcion','cliente_id','empleado_id','fecha','cantidad_productos','total_en_pesos'));
include_once('html_inf.php');
?>