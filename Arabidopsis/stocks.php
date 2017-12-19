<?php
$tip = 'El margen debe ser un n&uacute;mero que expresara el porcentaje. El monto debe ser un n&uacute;mero que expresar&aacute; los pesos. El separador de decimales es el punto (.) No poner s&iacute;mbolo';

include_once('html_sup.php');
include("scaffold.php");
$sql = "select id, descripcion from productos WHERE descripcion<>'GENERICO'";
$productos = mysql_query($sql);
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<?php
new Scaffold(
        "noeditable", "stocks", 1000, array('descripcion', 'disponibles,costo'), array(), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B', 'N'),
        array('disponibles!','0')
);
?>
<button type="button" id="abrir-alta" style="display: none" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal-alta"></button>
<div id="modal-alta" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close cerrar" data-dismiss="modal" id="cerrar">&times;</button>
                            <h4 class="modal-title">Baja de Stock</h4>
           </div>
                <table class="table" width="100%">
                    <form action="#" id="alta">
                        <tr>
                            <td align="left"><b>Producto<b></td><td><select id="producto" name="producto" class="js-example-basic-single" onchange="obtener_stock($(this).val())"><?php
                                    while ($row = mysql_fetch_array($productos)) {
                                        echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                                    }
                                    ?> </td>
                        </tr>
                        <tr>
                            <td align="left"><b>Stock Disponibles<b></td><td><input type="number"  id="disponible_modal" disabled="true" name="nuevo_stock"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Cantidad</b></td>
                                            <td class="tabla_cantidad_modal"><input type="number"  id="cantidad_modal" name="cantidad" class="requerido"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Motivo:</b></td>
                                            <td class="tabla_motivo"><input type="text" id="motivo" name="motivo" required="true" class="requerido mayuscula"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"></td><td><input type="button"  id="dar_baja" name="agregar" value="Aceptar" onclick="aceptar_bajar_stock()"></td>
                                        </tr>
                                        </form>
                                        </table>
                                        </div>
                                        </div>
                                        </div>

                                        <?php
                                        include_once('html_inf.php');
                                        ?> 
