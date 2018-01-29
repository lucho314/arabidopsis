 
<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

echo $msg;


$sql = "SELECT `nro_recibo_fundacion` FROM movimientos WHERE id=(SELECT MAX(id) AS id FROM movimientos where tipo_movimiento_id=1 and nro_recibo_fundacion<>'-')";
$result = mysql_query($sql);
$nro_recibo_fundacion = (mysql_num_rows($result) > 0) ? mysql_fetch_array($result) : array(999);


$variablecontrol = $_POST['variablecontrolposnavegacion'];

?>
<script> nro_recibo_fundacion =<?= $nro_recibo_fundacion[0] + 1 ?>;
</script>
<?php


if ($variablecontrol === 'create') {
    if ($_POST['tipo_movimiento_id'] === '1') {
        if ($_POST['concepto_movimiento_id'] !== '11') {
            $sql_orden = "SELECT AUTO_INCREMENT 
                            FROM information_schema.TABLES
                            WHERE TABLE_SCHEMA =  '$NombreDB'   
                            AND TABLE_NAME =  'movimientos'"; 
            
            
            $query = mysql_query($sql_orden);
            $id = mysql_fetch_array($query);
            echo "<script> id_genera_recibo=$id[0];</script>"; // aca seteo la variable con el id del movimiento para generar recibo


            $id_registro_creado = DevuelveValor('GENERADO', 'id', 'estados', 'descripcion');
            $sql_maquina = "INSERT INTO `registro_de_estados` ("
                    . "`id`, "
                    . "`descripcion`, "
                    . "`tabla`, "
                    . "`registro_id`, "
                    . "`fecha_cambio_estado`, "
                    . "`estado_id`, "
                    . "`usuario_id`, "
                    . "`empresa_id`"
                    . ") VALUES ("
                    . "NULL, "
                    . "'" . $_POST['descripcion'] . "',"
                    . " 'movimientos',"
                    . " $id[0],"
                    . " CURDATE(),"
                    . " $id_registro_creado,"
                    . " '" . $_POST['usuario_id'] . "',"
                    . " '" . $_POST['empresa_id'] . "'"
                    . ");";

            mysql_query($sql_maquina);
        }
    }
} else if ($variablecontrol === 'update') {
    if ($_POST['tipo_movimiento_id'] === '1') {
        $id = $_POST['id'];
        if ($_POST['concepto_movimiento_id'] !== '11')  echo "<script> id_genera_recibo=$id;</script>"; // aca seteo la variable con el id del movimiento para generar recibo
    }
}

new Scaffold("noeditable", "movimientos", 300000000, array('tipo_movimiento_id', 'fecha', 'monto', 'forma_de_pago_id', 'tipo_de_transaccion_id','fecha_cierre','fecha_vencimiento'), array(), array(), array(), array('D', 'E', 'B', 'N'),
    array('tipo_movimiento_id',1)
);


include_once('html_inf.php');
?>
<!-- Este es un formulario oculto que sirve para editar los datos 
en el caso de que cuando vea la vista previa del recibo decida cancelar para modificar-->
<form action="movimientos.php" method="post" style="display: none" id="formulario_modificar">
    <input type="hidden" value="edit" name="variablecontrolposnavegacion">
    <input type="hidden" value="new" name="id" id="id_modificar">
</form>

<script type="text/javascript">
	
$('#lista').DataTable({
	"columnDefs": [
                { "type": "numeric-comma", targets: 2 }
            ],

        "columns": [
            { "data": "tipo_movimiento_id" },
            { "data": "fecha" },
            { "data": "monto" ,
            	"render": function(data, type, full) { // Devuelve el contenido personalizado
            				a=$(data).text()
                          var x = (a == "-") ? 0 : a.replace( /,/, "." );
                         
        					return parseFloat(x);
                      }

        	},
            { "data": "forma_de_pago_id" },
            { "data": "tipo_de_transaccion_id" },
 	{ "data": "fecha_cierre" },
            { "data": "fecha_vencimiento" },
            { "data": "ver" },
            { "data": "editar" },
            { "data": "borrar" }
        ]
    });

$.fn.dataTable.ext.order['numeric-comma'] = function  ( settings, col )
{
	console.log(col);
}
</script>

