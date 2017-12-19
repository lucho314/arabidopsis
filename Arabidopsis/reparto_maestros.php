<?php
$tip = 'Los campos Total a cobrar, dinero ingresado y desfasaje puede cargarlos inicialmente con 0 (cero) ya que se actualizan en funci&oacute;n de las modificaciones en el sistema.';
include_once('html_sup.php');


//Debo generar el nuevo numero de reparto para poner en la descripcion.



$sql = "SELECT MAX(descripcion) AS descripcion FROM reparto_maestros";

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
// 	id_cliente  = document.getElementById('cliente_id').value;
// 	descripcion = descripcion+' - Cliente: '+id_cliente;

	document.getElementById('descripcion').value=descripcion;
	document.forms.crear.submit();
}
</script>
<?php
include("scaffold.php");
new Scaffold("noeditable","reparto_maestros",30);
include_once('html_inf.php');
?>
