<?php
$tip = 'En este formulario, el campo Descripci&oacute;n corresponde al N&uacute;mero de factura.';
include_once('html_sup.php');
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. -->

<!--<script type="text/javascript">
function creardescripcion() {

    nro_solicitud_rehabilitacion=document.getElementById('nro_solicitud_rehabilitacion').value;
    anio=document.getElementById('anio').value;

    descripcion=nro_solicitud_rehabilitacion+'/'+anio;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>-->
<?php
include("scaffold.php");
new Scaffold("editable","facturas",30);
include_once('html_inf.php');
?>