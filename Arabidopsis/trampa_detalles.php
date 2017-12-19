<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");


?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {
    
    var x = document.getElementById("estado_de_trampa_id").selectedIndex;
    var y = document.getElementById("estado_de_trampa_id").options;
    estado_de_trampa = y[x].text; 
        
    fecha       = document.getElementById('fecha').value;
      
        
 	descripcion = fecha+' - '+estado_de_trampa;

	document.getElementById('descripcion').value=descripcion;
       
	document.forms.crear.submit();
}
</script>
<?php

new Scaffold(
        "noeditable",
        "trampa_detalles",
        3000000,
        array('descripcion','fecha','estado_de_trampa_id'),
        array('empresa_id'),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N'),
	'0',
	'1'
        );



include_once('html_inf.php');
?>