<?php
include 'lib/connect_mysql.php';
//$localidad_id=$_POST['id'];
$sql="select longitud, latitud from localidads where id=".$_REQUEST['id'];
$query=mysql_query($sql);
while ($row = mysql_fetch_array($query)) {
    $array=['longitud'=>$row[0],'latitud'=>$row[1]];
}
echo json_encode($array);