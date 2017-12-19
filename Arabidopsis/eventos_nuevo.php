<?php
include_once('html_sup.php');
include("scaffold.php");

$provincia_id = htmlentities($_POST['provincia_id']);
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
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if (empty($variablecontrol)) {
    $ne = new Scaffold(
            "editable", "eventos", 0, array('descripcion'), array('empresa_id'), // Campos a ocultar en el formulario
            array(), // Campos relacionados
            array(), // Campos a ocultar del maestro en el detalle
            array('D', 'E', 'B', 'N'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
            array('provincia_id'), '1', '1'
    );
    $ne->new_row();
} else {
    $fecha=date_transform_usa($_POST['fecha_inicio']);
    $sql = "INSERT INTO `agendas` (`id`, `descripcion`, `titulo`, `fecha`, `hora`, `colaborador_id`, `observaciones`, `usuario_id`, `empresa_id`)  "
            . "VALUES (NULL,"
            . " '" . $_POST['descripcion'] . "',"
            . " '" . $_POST['nombre_del_evento'] . "', "
            . "'" . $fecha . "', "
            . "'00:00', "
            . "'1', "
            . "NULL, "
            . "1, "
            . "1);";
    mysql_query($sql);
    
    
    new Scaffold(
            "editable", "eventos", 30, array('descripcion'), array(), // Campos a ocultar en el formulario
            array(), // Campos relacionados
            array(), // Campos a ocultar del maestro en el detalle
            array('D', 'E', 'B', 'N'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
            array('provincia_id'), '0', '1'
    );
}

include_once('html_inf.php');
?>
<script>
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

    })
</script>