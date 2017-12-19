<?php
include_once('html_sup.php');
include("scaffold.php");
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
if ($variablecontrol === 'create') {
     $fecha=date_transform_usa($_POST['fecha_inicio']);
    $sql = "INSERT INTO `agendas` (`id`, `descripcion`, `titulo`, `fecha`, `hora`, `colaborador_id`, `observaciones`, `usuario_id`, `empresa_id`)  "
            . "VALUES (NULL,"
            . " 'Publicidad-" . $_POST['descripcion'] . "',"
            . " 'evento', "
            . "'" . $fecha. "', "
            . "'00:00', "
            . "'1', "
            . "NULL, "
            . "1, "
            . "1);";
    mysql_query($sql);
}

new Scaffold(
        "editable", "publicidad_detalles", 30, array('descripcion'), array('empresa_id'), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B', 'N'), '0', '1'
);




include_once('html_inf.php');
?>
