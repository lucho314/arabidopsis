<?php
$tip = 'La descripcion del rubro debe ser representativa del mismo';

include_once('html_sup.php');
include("scaffold.php");

new Scaffold(
        "editable",
        "rubros",
        3000000,
        array('descripcion'),
        array(),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );
include_once('html_inf.php');
?>