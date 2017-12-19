<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
include_once('html_sup.php');
$sql_recibos = "SELECT movimientos.fecha, movimientos.nro_recibo_fundacion,movimientos.colaborador_id,movimientos.monto,estados.descripcion,movimientos.id,registro_de_estados.fecha_cambio_estado "
        . "FROM `registro_de_estados` INNER JOIN movimientos on movimientos.id=registro_de_estados.registro_id "
        . "INNER JOIN estados on estados.id=registro_de_estados.estado_id"
        . " WHERE registro_de_estados.tabla='movimientos' AND"
        . " estados.descripcion='GENERADO' OR"
        . " estados.descripcion='ENVIADO' ORDER BY registro_de_estados.id DESC limit 200";

$recibos = mysql_query($sql_recibos);
?>

<h2> <u>Listado de recibos generados y enviados</U></h2>
<table  border="1" class="table table-striped table-responsive" id="tabla">
    <thead>
        <tr>
            <td align=\"center\"><b>Fecha emisi&oacute;n</b></td>
            <td align=\"center\"><b>Numero de recibo</b></td>
            <td align=\"center\"><b>Colaborador</b></td>
            <td align=\"center\"><b>Monto en pesos</b></td>
            <td align=\"center\"><b>Estado</b></td>
            <td align=\"center\"><b>Fecha/Acci&oacute;n</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysql_fetch_array($recibos)) :
            $row[2] = DevuelveValor($row[2], 'descripcion', 'colaboradors', 'id');
            $fecha_registro = date_transform_lat($row[6]);
            ?>
            <tr>
                <td><?= $row[0] ?></td>
                <td><?= $row[1] ?></td>
                <td><?= $row[2] ?></td>
                <td><?= $row[3] ?></td>
                <td><?= $row[4] ?></td>
                <td align="center"><?= $fecha_registro ?><br><a href="javascript:ver('<?=$row[5]?>')"><?php echo ($row[4]==='GENERADO')? '<span class="glyphicon glyphicon-eye-open"></span>':''?></td>
            </tr>

        <?php endwhile; ?>
    </tbody>
</table>


<?php
include_once('html_inf.php');
?>


<script>

    $('#tabla').DataTable({
        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        "language": {
            "url": "DataTables-1.10.12/media/Spanish.json"
        }
    });
    
    function ver(id){
        window.open("vista_previa_recibo.php?id=" + id+'&ban=ver', "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=600");
    }
</script>