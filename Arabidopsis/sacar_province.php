<?php
include 'lib/connect_mysql.php';

$sql_pais="select id, descripcion from provincias where pais_id=2";
$resultado_provincia=  mysql_query($sql_pais);
while ($row = mysql_fetch_row($resultado_provincia)) {
    if(substr($row[1],-8)==='Province')
    {
        
        $provincia= substr($row[1],0,-8);
        $sql="update provincias set descripcion='".$provincia."' where id=".$row[0];
        echo mysql_query($sql);
    }
} 
