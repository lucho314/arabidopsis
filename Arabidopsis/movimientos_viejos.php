
<script> nro_recibo_fundacion ="";
</script>
<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");
if(!isset($_POST['variablecontrolposnavegacion'])){
$_POST['variablecontrolposnavegacion']='new';
}
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if ($variablecontrol === 'create') {
            $id_registro_creado = DevuelveValor('GENERADO', 'id', 'estados', 'descripcion');
            $sql_maquina = "INSERT INTO `registro_de_estados` (`id`, `descripcion`, `tabla`, `registro_id`, `fecha_cambio_estado`, `estado_id`, `usuario_id`, `empresa_id`) "
                    . "VALUES (NULL, '" . $_POST['descripcion'] . "', 'movimientos', $id[0], CURDATE(), $id_registro_creado, '" . $_POST['usuario_id'] . "', '" . $_POST['empresa_id'] . "');";

            mysql_query($sql_maquina);
    }

new Scaffold("noeditable", "movimientos", 300000000, array('tipo_movimiento_id', 'fecha', 'monto', 'forma_de_pago_id', 'tipo_de_transaccion_id'), array(''), array(), array(), array('D', 'E', 'B', 'N')
);


include_once('html_inf.php');
?>

<script>
$(function(){
 $('#nro_recibo_fundacion').prop('readonly', false);
}) 

</script>


<!-- Este es un formulario oculto que sirve para editar los datos 
en el caso de que cuando vea la vista previa del recibo decida cancelar para modificar-->
<form action="movimientos.php" method="post" style="display: none" id="formulario_modificar">
    <input type="hidden" value="edit" name="variablecontrolposnavegacion">
    <input type="hidden" value="new" name="id" id="id_modificar">
</form>

