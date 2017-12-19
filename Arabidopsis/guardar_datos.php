<?php
$id    = $_REQUEST["id"];
$field = $_REQUEST["field"];
$value = $_REQUEST["value"];

include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');

$tabla = LimpiarXSS($_GET['tabla']);
$id_tabla = LimpiarXSS($_GET['id_tabla']);

if ($field == 'borrar')
{
    $sql = "DELETE FROM $tabla WHERE $id_tabla = $id";
    mysql_query($sql,$link);
    echo "<font color='#FF0000'>Borrado</font>";
}

else

{

$query = "UPDATE $tabla SET $field = '$value' WHERE $id_tabla = '$id'";
$result = mysql_query($query,$link) or die("Error");


include_once('diccionario_fk.php');

echo $value;

}


?>