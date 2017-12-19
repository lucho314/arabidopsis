<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");
?>
<script type="text/javascript">
function creardescripcion() {

    dni      = document.getElementById('dni').value;
    apellido = document.getElementById('apellido').value;
    nombre   = document.getElementById('nombre').value;    

    descripcion = apellido+', '+nombre+' - '+dni;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
<?php

new Scaffold(
        "noeditable",
        "empleados",
        3000000,
        array('descripcion','dni','nombre','celular'),
        array(),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );

include_once('html_inf.php');
?>