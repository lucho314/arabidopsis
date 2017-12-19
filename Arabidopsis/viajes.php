
<script type="text/javascript">
    function creardescripcion() {

        fecha =$('#fecha').val();
        destino=$('#destino_id').val();

        descripcion = fecha + ' / ' + destino;

        document.getElementById('descripcion').value = descripcion;
        document.forms.crear.submit();
    }
</script>

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
            $localidad_id = DevuelveValor($evento_id, 'destino_id', 'viajes', 'id');
            $provincia_id = DevuelveValor($localidad_id, 'provincia_id', 'localidads', 'id');
            $_POST['provincia_id'] = $provincia_id;

            //echo "Provincia: " . $provincia_id;
        }
    }
}


new Scaffold(
        "noeditable", 
        "viajes", 
        30, 
        array('descripcion','destino_id','dinero_destinado','saldo_total'), 
        array('empresa_id'), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B'), 
        array(), 
        array('destino_id'), // Campos a ocultar del maestro en el detalle
        array('provincia_id'), 
        '0', 
        '1'
);

include_once('html_inf.php');
?>
