<?php
include_once('html_sup.php');
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<!--<script type="text/javascript">
function creardescripcion() {

    costoinst=document.getElementById('costoinst').value;
    costoent=document.getElementById('costoent').value;

    descripcion=costoinst+' '+costoent;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>-->
<?php
new Scaffold("noeditable","areas",30);
include_once('html_inf.php');
?>
