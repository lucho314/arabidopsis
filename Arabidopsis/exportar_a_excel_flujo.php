<?php
include_once 'lib/connect_mysql.php';

header("Content-type: application/vnd.ms-excel" ) ; 
header("Content-Disposition: attachment; filename=flujo.xls" ) ; 
//en la sigte linea colocar entre comillas el nombre del servidor mysql (generalmente, localhost) 

$sql = urldecode($_GET['sql']);


$qry=mysql_query($sql) ; 
$campos = mysql_num_fields($qry) ; 
$i=0; 
echo "<table><tr>"; 
while($i<$campos){ 
echo "<td>". mysql_field_name ($qry, $i) ; 
echo "</td>"; 
$i++; 
} 
echo "</tr>"; 
while($row=mysql_fetch_array($qry)){ 
echo "<tr>"; 
for($j=0; $j<$campos-1; $j++) { 
echo "<td>".$row[$j]."</td>"; 
$ultino=$j;
} 
$acumulado+=($row[$ultino-1]-$row[$ultino]);
echo "<td>".$acumulado."</td>";
echo "</tr>"; 
} 
echo "</table>"; 
?> 