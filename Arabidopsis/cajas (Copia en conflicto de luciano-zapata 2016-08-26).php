<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

echo $msg;
new Scaffold("editable","movimientos",
        30,
        array('descripcion','fecha','tipo_transaccion_id','colaborador_id','monto'),
        array('empresa_id'),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );
include_once('html_inf.php');
?>