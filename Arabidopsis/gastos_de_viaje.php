<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if ($variablecontrol === 'create') {
    $importe = $_POST['importe'];
    $viaje_id = $_POST['viaje_id'];
    $sql = "SELECT saldo_total FROM viajes where id=$viaje_id";
    echo $sql;
    $resultado = mysql_query($sql);
    $saldo_total = mysql_fetch_row($resultado);
    $nuevo_saldo = $saldo_total[0] + $importe;
    $sql_update = "UPDATE viajes SET saldo_total=$nuevo_saldo WHERE id=$viaje_id";
    echo mysql_query($sql_update);
}

new Scaffold("editable", "gastos_de_viajes", 300000000, array('descripcion', 'viaje_id', 'fecha', 'importe'), array(''), array(), array(), array('D', 'E', 'B', 'N')
);

include_once('html_inf.php');
?>
<script>
    $(function () {
        bloq_nro_comprobante($('#con_comprobante_id').val());

    })
    $('#con_comprobante_id').change(function () {
        bloq_nro_comprobante($(this).val());
    })

    function bloq_nro_comprobante(id) {
        if (id === '2') {
            $('#nro_comprobante').prop('readonly', true);
        } else {
            $('#nro_comprobante').prop('readonly', false);

        }
    }
</script>