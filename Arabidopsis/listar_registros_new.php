<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
 <link rel="stylesheet" type="text/css" media="all" href="style.css" />
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Actualización de datos</title>
</head>
<body>

<div id="content">

<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');

$totalcolumnas = 0;

$id_filtro    = LimpiarXSS($_POST['id_filtro']);
$id_operacion = LimpiarXSS($_POST['id_operacion']);


$operaciones = mysql_query("SELECT * FROM operacion WHERE id_operacion = $id_operacion",$link);



while($op = mysql_fetch_array($operaciones, MYSQL_BOTH)){


// VALORES A DEFINIR PARA EL LISTADO
if (!empty($op['criterio'])) {
$criterio 	= 'WHERE '.$op['criterio'].'='.$id_filtro;}
$orden		= $op['orden'];
// FOREING KEYS
$totalfk 	= $op['totalfk'];
$fk		= explode(",",$op['fkarray']);

for ($o=0; $o<$totalfk; $o++) {
   $fkt[$o] = substr($fk[$o],0,-3);
}
// TABLA PRINCIPAL
$tabla 		= $op['tabla'];
$id_tabla 	= $op['id_tabla'];

// FIN VALORES A DEFINIR PARA EL LISTADO---------------------

}


//Cuento el total  registros de la tabla
$contar="SELECT MAX($id_tabla) FROM $tabla";
$res=mysql_query($contar,$link);
$total_registros=mysql_fetch_array($res); //Cuenta el total de registros de la tabla.
$id_nuevo = $total_registros[0] + 1;

$consulta = mysql_query("SELECT * FROM $tabla $criterio ORDER BY $orden",$link);

?>
<a href="javascript:guardar();">Registro nuevo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="javascript:actualizar();">Actualizar pantalla</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="index.php">Listar otro rubro</a><br />
<iframe src="iframe.html" width="100" height="10" frameborder="0" name="oculto"></iframe>
<table class="sortable resizable editable" id="datos">
    <thead>
            <tr>
<?php

$columnas="DESCRIBE $tabla";
$qcolumnas=mysql_query($columnas,$link);
while($rowc = mysql_fetch_array($qcolumnas, MYSQL_BOTH)){

echo '<th id="'.$rowc[0].'">'.$rowc[0].'</th>';  //El segundo $row lo reemplazo por el diccionario.
$totalcolumnas = $totalcolumnas + 1;
}
?>
      <th id="borrar">Acciones</th>
 </tr>
</thead>

<tbody>

<?php while($row = mysql_fetch_array($consulta, MYSQL_ASSOC)){


$title = array_keys($row);
echo '<tr id="'.$row[$title[0]].'">';


for ($j=0; $j<$totalcolumnas; $j++) {

	for ($i=0; $i<$totalfk; $i++) {
	   if ((string)$title[$j]==$fk[$i])
	   {
		$table = substr($title[$j],0,-3).'s';
		$id    = 'id';
		$campo = 'descripcion';
        	$valor = DevuelveValor($row[$title[$j]],$campo,$table,$id);

        	break 1;
           }
           else $valor = $row[$title[$j]];
	}

echo '<td>'.$valor.'</td>';

} //fin del for j



?>


   <td>Borrar</td>
 </tr>

<?php } ?>




    </tbody>
</table>
</div>
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="fabtabulous.js"></script>
<!--<script type="text/javascript" src="viejosfastinit.js"></script>-->
<script type="text/javascript" src="tablekit.js"></script>
<script type="text/javascript">

        var id_nuevo = <?php echo $id_nuevo;?>;

        function guardar()
        {
        window.open('agregar_registro.php?id_filtro=<?php echo $id_filtro;?>&id_tabla=<?php echo $id_tabla;?>&tabla=<?php echo $tabla;?>&totalcolumnas=<?php echo $totalcolumnas;?>', 'oculto');
        location.reload();
        }

        function actualizar()
        {
            location.reload();
        }

        TableKit.options.editAjaxURI = 'guardar_datos.php?id_tabla=<?php echo $id_tabla;?>&tabla=<?php echo $tabla;?>';

        TableKit.Editable.selectInput('profesional', {}, [
                                ['No','0'],
                                ['Si','1']
                        ]);

        TableKit.Editable.selectInput('resaltado', {}, [
                                ['Comun','0'],
                                ['Lindo','1'],
                                ['Maquillado','2']
                        ]);

	<?php for ($h=0; $h<$totalfk; $h++) { ?>

        TableKit.Editable.selectInput('<?php echo $fk[$h];?>', {}, [
                        <?php
                            $tablafk = $fkt[$h].'s';
                            $query2 = mysql_query("SELECT * FROM $tablafk ORDER BY name");
                            while($result_query2 = mysql_fetch_array($query2))
                            echo "['$result_query2[1]','$result_query2[0]'],";
                        ?>
                        ]);

	<?php } ?>


        TableKit.Editable.multiLineInput('title');

        TableKit.Editable.selectInput('borrar', {}, [
                                ['Borrar','borrar'],
                                ['Archivar','archivar']
                        ]);



</script>
        </body>
</html>
