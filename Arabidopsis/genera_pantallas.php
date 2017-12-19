<?php
//genera_pantallas.php
//Este script crea automáticamente los archivos php para acceder a la base de datos utilizando los nombres de las tablas. También genera el menu (menu.php)



//Tomo los nombres de las tablas y los cargo en un array


//Recorro el array asignando los nombres de las tablas a los archivos y a las variables que corresponden a la tabla correspondiente del scaffold.

  $ar=fopen("datos.txt","a") or
    die("Problemas en la creacion");
  fputs($ar,"<?php include_once('html_sup.php');include('scaffold.php');new Scaffold();"
  fputs($ar,"\n");
  fputs($ar,$_REQUEST['comentarios']);
  fputs($ar,"\n");
  fputs($ar,"--------------------------------------------------------");
  fputs($ar,"\n");
  fclose($ar);
  echo "Los datos se cargaron correctamente.";



?>