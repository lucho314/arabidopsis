<?php
include 'variables.php';
mysql_pconnect($Servidor, $Usuario, $Clave) or die("Error al conectar a mysql");
mysql_select_db($NombreDB) or die("Error  seleccionar base de datos: ".$Servidor." ".$Usuario." ".$Clave);
$link=mysql_pconnect($Servidor, $Usuario, $Clave) or die("Error al conectar a mysql");
mysql_set_charset('utf8');

?>