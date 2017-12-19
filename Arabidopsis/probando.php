<?php
include_once('html_sup.php');
include("scaffold.php");

new Scaffold("noeditable", "movimientos", 300000000, array('tipo_movimiento_id', 'fecha', 'monto', 'forma_de_pago_id'), array(''), array(), array(), array('D', 'E', 'B', 'N')
);
?>
<div class="panel panel-primary" id="mostrar">
    <div class="panel-heading">
        <h3 class="panel-title">
            Movimiento
        </h3>
    </div></div>

<?php include_once('html_inf.php');
?>
<script>
    $('#panel').click(function () {
        $(this).slideToggle(1200, function () {
            $('#mostrar').show();
        });
    });
    
        $('#mostrar').click(function () {
        $('#panel').slideToggle(1200, function () {
            $('#mostrar').hide();
        });
    });
</script>

