<?php
include_once('lib/connect_mysql.php');
$sql="DELETE FROM registro_de_estados where usuario_id=".$_POST['id'];
mysql_query($sql);