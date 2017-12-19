<?php
include_once('html_sup.php');
$tabla = $_GET['tabla'];

switch ($tabla)  {
	case 1:
	    $mostrar = "actividads";
	    break;
	case 2:
	    $mostrar = "pilotos";
	    break;
	case 3:
	    $mostrar = "aeronaves";
	    break;
	case 4:
	    $mostrar = "aerodromos";
	    break;
}




include("scaffold.php");
new Scaffold($mostrar,30);
include_once('html_inf.php');
?>
