<?php
include 'lib/connect_mysql.php';
$id=$_REQUEST['id'];

$sql = "SELECT id, descripcion FROM tipo_de_transaccions WHERE forma_de_pago_id=$id";
//echo $sql;
$query=mysql_query($sql);
if(isset($_POST["salida"]))
{
	$i=0;
	while ($row = mysql_fetch_array($query)) {
		if($row[1]!="GENERICO"){
			$data[$i]['value']=$row[0];
		$data[$i]["text"]=$row[1];
		$i++;
		}
		
	}

	echo json_encode($data);

	die();
}

while ($row = mysql_fetch_array($query)) {

     $opcion.="<option value='" . $row[0] . "'>" . $row[1] . "</option>";
}

echo $opcion;