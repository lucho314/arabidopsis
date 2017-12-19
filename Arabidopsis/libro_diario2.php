<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
include_once('html_sup.php');

$fecha_inicio = date_transform_usa($_REQUEST['fecha_inicio']);
$fecha_fin = date_transform_usa($_REQUEST['fecha_fin']);

$sql = "SELECT u.* FROM (SELECT *, 'S'as 'tipo' FROM salidas UNION SELECT *,'E'as 'tipo' FROM entradas)AS u "
        . "where u.fecha BETWEEN '" . $fecha_inicio . "' and '" . $fecha_fin . "' order by fecha,forma_de_pago_id";


$libros = mysql_query($sql);
?>

<div class="panel panel-primary" style="width: 100%" >
    <div class="panel-heading">
        <h3 class="panel-title"><?= ($id_forma_pago != false) ? 'Seleccione Fecha y Flujo' : 'Seleccione Fecha' ?></h3>
    </div>
    <table width="100%" style="text-align:center;">
        <tr><td>  &nbsp; </td></tr>
        <tr>
        <form action="libro_diario2.php" method="post">
            <td><b>Fecha Inicio: </b></td>
            <td><input type="text" name="fecha_inicio" id="fecha_inicio" value="<?= $_REQUEST['fecha_inicio'] ?>" class="datepicker"></td>
            <td><b>Fecha fin</td>
            <td><input type="text" name="fecha_fin" id="fecha_fin" value="<?= $_REQUEST['fecha_fin'] ?>" class="datepicker"></td>
            <td><input type="submit" class="btn btn-primary" value="Actualizar"></td> 
        </form>
        </tr>
    </table>
</div>





<table class="table cell-border " border='1' id="libro">
    <thead>
        <tr>
            <th><b>Fecha</b></th>
            <th align="center"><b>Cuenta y Detalle</b></th>
            <th align="center"><b>Debe</b></th>
            <th align="center"><b>Haber</b></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysql_fetch_array($libros)) :
            $bandera = 0;
            if ($forma_de_pago !== $row[3]) {
                $forma_de_pago = $row[3];
                $pago = DevuelveValor($row[3], 'descripcion', 'forma_de_pagos', 'id');
                $bandera = 1;
            }
            ?>
            <tr class="success">
                <?php if ($bandera === 1): ?>
                    <td></td>
                    <td><b><?= $pago ?></b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="success">

                <?php endif; ?>
                <td><?= $row[0] ?></td>
                <td><?= $row[1] ?></td>
                <?php
                if ($row[6] === 'E') {
                    $entradas+=$row[2];
                    echo "<td align=\"center\">$row[2]</td>";
                    echo "<td></td>";
                } else {
                    $salidas+=$row[2];
                    echo "<td></td>";
                    echo "<td align=\"center\">$row[2]</td>";
                }
                ?>
            </tr>
            <?php
        endwhile;
        ?>
        <tr>
            <td></td>
            <td align="center">TOTALES</td>
            <td align="center"><?= $entradas ?></td>
            <td align="center"><?= $salidas ?></td>
        </tr>
    </tbody>
</table>

<?php
include_once('html_inf.php');
?>
<style>
    th{
        text-align: center;

    }  
</style>

<script>
    $(function () {

        $('#libro').DataTable({
            "bSort": false,
            "bPaginate": false,
            "bFilter": false,
            dom: 'Bfrtip',
            buttons: [
               'pdf','excel'

            ],
            "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            },
        })
    })
</script>