<?php
$tip = 'Si se trata de un ENTE proveedor de energ&iacute;a, recuerde que puede colocar un gui&oacute;n (-) en los campos que no corresponden. El campo "Ente" corresponde a la distribuidora que provee el servicio al ente en cuesti&oacute;n.';
include_once('html_sup.php');

?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    razon_social=document.getElementById('razon_social').value;
    apellido=document.getElementById('apellido').value;
    nro_documento=document.getElementById('nro_documento').value;


    descripcion=nro_documento+' '+apellido+' '+razon_social;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
<?php
include("scaffold.php");
new Scaffold("noeditable","ente_externos",30,array('nro_documento','razon_social','nombre','apellido','ciudad_id','calle','numero'));
include_once('html_inf.php');
?>
