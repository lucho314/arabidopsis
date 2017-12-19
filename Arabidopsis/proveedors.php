<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");


$provincia_id = htmlentities($_POST['provincia_id']);
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if (!empty($variablecontrol)) {
    if (($variablecontrol != "list")) {
        if (empty($provincia_id)) {
            $evento_id = $_POST['id'];
            $localidad_id = DevuelveValor($evento_id, 'localidad_id', 'proveedors', 'id');
            $provincia_id = DevuelveValor($localidad_id, 'provincia_id', 'localidads', 'id');
            $_POST['provincia_id'] = $provincia_id;

            //echo "Provincia: " . $provincia_id;
        }
    }
} 

new Scaffold(
        "noeditable", 
        "proveedors", 
        100, 
        array('razon_social', 'cuit', 'telefono'), 
        array(), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B'), 
        array(), 
        array('localidad_id'), // Campos a ocultar del maestro en el detalle
        array('provincia_id'), 
        '0', 
        '1'
);


include_once('html_inf.php');
?>

<script>
    $('.tabla_localidad_id').eq(1).append("<a href='#' class='btn btn-default' id='modificar_pais'> Cambiar pais<a>");
    $('#modificar_pais').click(function(){
        
        window.open("formulario_modificar_ciudad.php", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=600");
    })
</script>