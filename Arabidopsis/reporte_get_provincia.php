<?php
include 'lib/connect_mysql.php';
$id=$_REQUEST['id'];

$sql = "SELECT id, descripcion FROM provincias WHERE pais_id=$id";
$opcion = "<option value=''>Seleccione provincia</option>";
//echo $sql;
$query=mysql_query($sql);
while ($row = mysql_fetch_array($query)) {
    $opcion.="<option value='" . $row[0] . "'>" . $row[1] . "</option>";
}

echo  mb_convert_encoding($opcion,  'UTF-8', 'ISO-8859-1');