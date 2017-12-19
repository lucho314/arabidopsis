<?php
include_once('lib/connect_mysql.php');
$id=$_REQUEST['id'];
$sql="UPDATE `archivos` SET `visible_colaborador`=!`visible_colaborador` WHERE `id`=".$id;
return mysql_query($sql);

?>