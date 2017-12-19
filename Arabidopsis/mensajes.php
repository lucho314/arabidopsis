<?php
include_once('html_sup.php');
include("scaffold.php");

new Scaffold("editable", "mensajes", 300000000, array('descripcion'), array(), array(), array(), array('D', 'E')
);

include_once('html_inf.php');
?>
