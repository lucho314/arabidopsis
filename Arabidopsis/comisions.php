<?php

include_once('html_sup.php');
include("scaffold.php");



new Scaffold("noeditable","comisions",30,array('descripcion','empleado_id','pedido_maestro_id','fecha','monto'));


include_once('html_inf.php');
?>
