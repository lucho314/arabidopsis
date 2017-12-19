<?php
$tip = 'El margen debe ser un n&uacute;mero que expresara el porcentaje. El monto debe ser un n&uacute;mero que expresar&aacute; los pesos. El separador de decimales es el punto (.) No poner s&iacute;mbolo';

include_once('html_sup_min.php');
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    codigo=document.getElementById('codigo').value;
    nombre=document.getElementById('nombre').value;

    descripcion = codigo+' - '+nombre;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
<?php
new Scaffold("listado","productos",500000,array('descripcion','proveedor_id','costo','margen','disponibles'));
include_once('html_inf.php');
?>