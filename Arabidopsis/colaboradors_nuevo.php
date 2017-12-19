<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");
 
$provincia_id = htmlentities($_POST['provincia_id']);

echo $msg;
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if (empty($variablecontrol)) {
    $ne = new Scaffold(
            "noeditable", "colaboradors", 0, array('descripcion'), array('empresa_id'), // Campos a ocultar en el formulario
            array(), // Campos relacionados
            array(), // Campos a ocultar del maestro en el detalle
            array('D', 'E', 'B', 'N'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
            array('provincia_id'), '1', '1'
    );
    $ne->new_row();
} else {
    new Scaffold(
            "noeditable", "colaboradors", 30, array('descripcion', 'cuit', 'domicilio', 'email', 'telefono'), array(), // Campos a ocultar en el formulario
            array(), // Campos relacionados
            array(), // Campos a ocultar del maestro en el detalle
            array('D', 'E', 'B'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
            array('provincia_id'), '0', '1'
    );
}

include_once('html_inf.php');
?>
