<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");


new Scaffold(
        "noeditable",
        "extintors",
        3000000,
        array('descripcion','cliente_id','fecha_vencimiento_verificacion'),
        array(),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );

include_once('html_inf.php');
?>