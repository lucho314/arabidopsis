<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");


?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {
    
    var x = document.getElementById("scliente_id").selectedIndex;
    var y = document.getElementById("scliente_id").options;
    cliente = y[x].text; 
        
    fecha       = document.getElementById('fecha').value;
    nro_factura = document.getElementById('nro_factura').value;
        
        
 	descripcion = fecha+' - '+nro_factura+' - '+cliente;

	document.getElementById('descripcion').value=descripcion;
       
	document.forms.crear.submit();
}
</script>
<?php

new Scaffold(
        "noeditable",
        "factura_maestros",
        3000000,
        array('cliente_id','fecha','total'),
        array('detalle','control','subtotal','impuesto','iva_21','iva_105','total','anulada','empresa_id'),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );



include_once('html_inf.php');
?>