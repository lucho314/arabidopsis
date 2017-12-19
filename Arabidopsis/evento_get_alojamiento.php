<?php
include 'lib/connect_mysql.php';
$id=$_REQUEST['id'];

$sql = "SELECT id, descripcion FROM alojamientos WHERE localidad_id=$id";
$opcion = "<option value=''>Seleccionar Alojamiento</option>";
//echo $sql;
$query=mysql_query($sql);
while ($row = mysql_fetch_array($query)) {
    $opcion.="<option value='" . $row[0] . "'>" . $row[1] . "</option>";
}

echo $opcion;


