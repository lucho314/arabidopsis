<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

$provincia_id = htmlentities($_POST['provincia_id']);
echo $msg;
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if (empty($variablecontrol)) {
    $ne = new Scaffold(
            "editable", "medios", 0, array('descripcion'), array('empresa_id'), // Campos a ocultar en el formulario
            array(), // Campos relacionados
            array(), // Campos a ocultar del maestro en el detalle
            array('D', 'E', 'B', 'N'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
            array('provincia_id'), '1', '1'
    );
    $ne->new_row();
} else {
    new Scaffold(
            "editable", "medios", 30, array('descripcion'), array(), // Campos a ocultar en el formulario
            array(), // Campos relacionados
            array(), // Campos a ocultar del maestro en el detalle
            array('D', 'E', 'B', 'N'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
            array('provincia_id'), '0', '1'
    );
}

include_once('html_inf.php');
?>
<script>
    $(function () {
        bloquea_desbloquea($('#tipo_de_medio_id').val());
        $('#tipo_de_medio_id').change(function () {
            bloquea_desbloquea($(this).val());
        })
        function bloquea_desbloquea(tipo_medio)
        {
            switch (tipo_medio)
            {
                case '2':
                    $('#nro_canal').attr('readonly', true);
                    $('#frecuencia').attr('readonly', false);
                    break;
                case '3':
                    $('#frecuencia').attr('readonly', true);
                    $('#nro_canal').attr('readonly', false);
                    break;
                case '4':
                    $('#frecuencia').attr('readonly', true);
                    $('#nro_canal').attr('readonly', true);
                    break;
                case '5':
                    $('#frecuencia').attr('readonly', true);
                    $('#nro_canal').attr('readonly', true);
                    break;

                default:
                    $('#frecuencia').attr('readonly', false);
                    $('#nro_canal').attr('readonly', false);
                    break;
            }
        }
    })
</script>
