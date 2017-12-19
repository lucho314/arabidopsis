<?php
include_once('html_sup.php');
include("scaffold.php");


$provincia_id = htmlentities($_POST['provincia_id']);
$variablecontrol = $_POST['variablecontrolposnavegacion'];



if (!empty($variablecontrol)) {
    if (($variablecontrol != "list")) {
        if (empty($provincia_id)) {
            $evento_id = $_POST['id'];
            $localidad_id = DevuelveValor($evento_id, 'localidad_id', 'eventos', 'id');
            $provincia_id = DevuelveValor($localidad_id, 'provincia_id', 'localidads', 'id');
            $_POST['provincia_id'] = $provincia_id;

            echo "Provincia: " . $provincia_id;
        }
    }
}
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<!--<script type="text/javascript">
function creardescripcion() {

    costoinst=document.getElementById('costoinst').value;
    costoent=document.getElementById('costoent').value;

    descripcion=costoinst+' '+costoent;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>-->
<?php
new Scaffold(
        "editable", "eventos", 30, array('descripcion'), array('empresa_id'), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
        array('provincia_id'), '0', '0'
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


        var id = $('#localidad_id').val();
        $.ajax({
            type: "POST",
            url: "eventos_get_salons.php",
            dataType: "html",
            data: {
                id: id
            },
            success: function (r) {
                $("#salon_id").html(r);
            }
        });

        $.ajax({
            type: "POST",
            url: "evento_get_alojamiento.php",
            dataType: "html",
            data: {
                id: id
            },
            success: function (r) {
                $("#alojamiento_id").html(r);
            }

        });
    })



    $('#localidad_id').change(function () {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "eventos_get_salons.php",
            dataType: "html",
            data: {
                id: id
            },
            success: function (r) {
                $("#salon_id").html(r);
            }

        });

        $.ajax({
            type: "POST",
            url: "evento_get_alojamiento.php",
            dataType: "html",
            data: {
                id: id
            },
            success: function (r) {
                $("#alojamiento_id").html(r);
            }

        });

    })



    < script >
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

</script>