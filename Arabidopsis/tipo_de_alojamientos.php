<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");

new Scaffold(
        "editable",
        "tipo_de_alojamientos",
        30,
        array('descripcion'),
        array('empresa_id'),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')        
        );
include_once('html_inf.php');
?>