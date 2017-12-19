<?php

$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

new Scaffold("editable",
        "viaticos_y_movilidads",
        300000000,
        array('descripcion'),
        array(''),              
        array(),                                                         
        array(),                                                        
        array('D','E','B','N')        
        );

include_once('html_inf.php');
?>
