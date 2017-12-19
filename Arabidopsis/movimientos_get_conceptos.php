<?php
include 'lib/connect_mysql.php';
$id=$_REQUEST['id'];

$sql = "SELECT id, descripcion FROM concepto_movimientos WHERE tipo_movimiento_id=$id";
//echo $sql;
$query=mysql_query($sql);
while ($row = mysql_fetch_array($query)) {

     $opcion.="<option value='" . $row[0] . "'>" . $row[1] . "</option>";
}

echo $opcion;