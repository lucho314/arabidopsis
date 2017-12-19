<?php
include_once '../lib/connect_mysql.php';
header('Content-type: text/json');
// TOMO LOS DATOS DE LA BASE DE DATOS
$sql = "SELECT * FROM agendas";
$result = mysql_query($sql);
echo '[';
$separator = "";

while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo $separator;
    $fecha      = $r['fecha'];
    $hora       = $r['hora'];
    $cliente_id = $r['colaborador_id'];
    $id         = $r['id'];
    $fechaYhora = $fecha.' '.$hora;
    echo '  { "date": "'.$fechaYhora.'", "type": "meeting", "title": "'.$r['titulo'].'", "description": "'.$r['descripcion'].'", "url": "detalle_agenda.php?id='.$id.'" }';
 $separator = ",";   
}
echo ']';
?>