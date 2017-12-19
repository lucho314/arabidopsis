<?php

$tip = '';

include_once('html_sup.php');


//Selecciono la suma de todos los totales de tipo de movimiento entrada y forma de pago contado efectivo.
        

$sql_rep = "SELECT SUM(monto_en_pesos) FROM movimientos WHERE tipo_movimiento_id = 1 AND forma_de_pago_id = 2";
$q_rep = mysql_query($sql_rep);

while ($row = mysql_fetch_array($q_rep)) {
    $total_entrada = $row[0];
}

$sql_rep = "SELECT SUM(monto_en_pesos) FROM movimientos WHERE tipo_movimiento_id = 2 AND forma_de_pago_id = 2";
$q_rep = mysql_query($sql_rep);

while ($row = mysql_fetch_array($q_rep)) {
    $total_salida = $row[0];
}

$saldo = $total_entrada - $total_salida;




##################  GENERO EL JAVASCRIPT QUE ACTIVARA O NO LOS CAMPOS
?>


<br>
<div class="panel panel-warning" style="width: 800px">
    <div class="panel-heading">
        <h3 class="panel-title">Saldo de caja (Contado efectivo)</h3>
    </div>
    <div class="panel-body" style="text-align: left; width: 400px;">
        <br>
        <?php echo "<h2>Entrada: $".$total_entrada."</h2><hr size=\"1\"><h2>Salida: $".$total_salida."</h2><hr size=\"1\"><h2>Saldo: $".$saldo."</h2>";?>

    </div>
</div>
<?php
include_once('html_inf.php');
?>

<script>
    $('#pais_id').change(function () {
        var id = $(this).val();

        $.post('reporte_get_provincia.php', {id: id}, function (data) {
            $('#provincia_id').html(data);
        }, "html");
        $('#provincia_id').attr('disabled', false);
    });
    $('#provincia_id').change(function () {
        var id = $(this).val();

        $.post('reporte_get_localidad.php', {id: id}, function (data) {
            $('#localidad_id').html(data);
        }, "html");
        $('#localidad_id').attr('disabled', false);
    });

</script>