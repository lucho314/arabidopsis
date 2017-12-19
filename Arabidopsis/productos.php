<?php
$tip = 'El margen debe ser un n&uacute;mero que expresara el porcentaje. El monto debe ser un n&uacute;mero que expresar&aacute; los pesos. El separador de decimales es el punto (.) No poner s&iacute;mbolo';

include_once('html_sup.php');
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<!--<script type="text/javascript">
function creardescripcion() {

    proveedor_id = document.forms.crear.proveedor_id.selectedIndex;
//     var valor  = document.forms.crear.rubro_id.options[indice].text;


    codigo = document.getElementById('codigo').value;
    autor = document.getElementById('autor').value;
    //proveedor_id = document.getElementById('proveedor_id').value;

    descripcion = codigo+' - '+proveedor_id+' - '+autor;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>-->
<?php

new Scaffold(
        "editable",
        "productos",
        3000000,
        array('descripcion','proveedor_id'),
        array(),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );


include_once('html_inf.php');
?>