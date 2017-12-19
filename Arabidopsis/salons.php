<?php

$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

$provincia_id = htmlentities($_POST['provincia_id']);
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if (!empty($variablecontrol)) {
    if (($variablecontrol != "list")) {
        if (empty($provincia_id)) {
            $evento_id = $_POST['id'];
            $localidad_id = DevuelveValor($evento_id, 'localidad_id', 'salons', 'id');
            $provincia_id = DevuelveValor($localidad_id, 'provincia_id', 'localidads', 'id');
            $_POST['provincia_id'] = $provincia_id;

            //echo "Provincia: " . $provincia_id;
        }
    }
} 


new Scaffold(
        "editable", "salons", 30, array('descripcion'), array('empresa_id'), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
        array('provincia_id'), '0', '1'
);

include_once('html_inf.php');
?>
 
<script>
    $(function () {
        $('#longitud').attr('readonly', true);
        $('#latitud').attr('readonly', true);
        var id = $('#localidad_id').val();
        $.post('salons_trae_long_lat.php', {id: id}, function (data) {
            var longitud = data.longitud;
            var latitud = data.latitud;
            $('#longitud').val(longitud);
            $('#latitud').val(latitud);
        }, "json")
    })
    $('#localidad_id').change(function () {
        var id = $(this).val();
        $.post('salons_trae_long_lat.php', {id: id}, function (data) {
            var longitud = data.longitud;
            var latitud = data.latitud;
            $('#longitud').val(longitud);
            $('#latitud').val(latitud);
        }, "json")
    })
</script>