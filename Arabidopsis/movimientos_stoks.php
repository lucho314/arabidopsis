<?php
include_once('html_sup.php');
include("scaffold.php");
$sql="SELECT registro_de_estados.descripcion, stocks.producto_id,fecha_cambio_estado,estados.descripcion from registro_de_estados"
        . " INNER JOIN stocks on stocks.id=registro_de_estados.registro_id INNER JOIN estados on estados.id=registro_de_estados.estado_id where tabla='stocks'";
$result=  mysql_query($sql);
 ?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->
<h2> <u>Movimiento de Stock</U></h2>
<table  border="1" class="table table-striped table-responsive" id="tabla">
    <thead>
        <tr>
            <td align=\"center\"><b>Fecha</b></td>
            <td align=\"center\"><b>Descripcion</b></td>
            <td align=\"center\"><b>Producto</b></td>
            <td align=\"center\"><b>Movimiento</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysql_fetch_array($result)) :
            $row[1] = DevuelveValor($row[1], 'descripcion', 'productos', 'id');
            ?>
            <tr>
                <td><?= mb_convert_encoding($row[2], 'ISO-8859-2','UTF-8') ?></td>
                <td><?= mb_convert_encoding($row[0], 'ISO-8859-2','UTF-8') ?></td>
                <td><?= $row[1] ?></td>
                <td><?php echo ( $row[3]=='CREADO')?'ALTA':mb_convert_encoding( $row[3], 'ISO-8859-2','UTF-8') ?></td>
            </tr>

        <?php endwhile; ?>
    </tbody>
</table>


<?php
include_once('html_inf.php');
?>