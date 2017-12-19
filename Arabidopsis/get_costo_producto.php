<?php

include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$sql = "SELECT costo from stocks where producto_id=" . $_REQUEST['id'];
$result = mysql_query($sql);
$costo = mysql_fetch_array($result);
echo $costo[0];
