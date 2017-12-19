
<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup_min.php');
include_once('../lib/connect_mysql.php');
include_once('../lib/funciones.php');
$date = new DateTime("-18 months");
?>



<script>
    $(function () {

        $('#lista').DataTable({
           "bSort": false,
            "bPaginate": false,
            dom: 'Bfrtip',
            buttons: [
                'pdf', 'excel'

            ],
            "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            }
        })
    })

function verrecibo(id_genera_recibo){
    $('#id_genera_recibo').val(id_genera_recibo);
    $('#verrecibo').submit();
}

</script>

<form method="post" target="_blank" id="verrecibo" action="imprimir_comprobante.php">
    <input type="hidden" name="id" id="id_genera_recibo">
    <input type="hidden" name="apertura" value="pre">
</form>

            <p><b>En esta seccion podra ver las donaciones que usted relizo durante los ultimos 18 meses</b></p>





            <?php
            session_start();
            $id = $_SESSION['usuario_id'];
            $descripcion = DevuelveValor($id, 'email', 'usuarios', 'id');

             $id = DevuelveValor($descripcion, 'id', 'colaboradors', 'email');


           $sql="SELECT m.id,fecha,tm.descripcion as 'tipo_moneda',monto,cm.descripcion as 'concepto',fp.descripcion as 'forma_pago'
                from movimientos m 
                inner join tipo_monedas tm on tm.id=m.tipo_moneda_id
                inner join concepto_movimientos cm on cm.id=m.concepto_movimiento_id
                inner join forma_de_pagos fp on fp.id=m.forma_de_pago_id
                where m.colaborador_id=".$id." and fecha>='".$date->format("Y-m-d")."'";
            $datos=mysql_query($sql);


            ?>

              <table width="100%" border="1" class="table table-striped table-responsive" id="lista">
        <thead>
            <tr>
                <td align="center"><b>Fecha</b></td>
                <td align="center"><b>Moneda</b></td>
                <td align="center"><b>Monto</b></td>
                <td align="center"><b>Concepto</b></td>
                <td align="center"><b>Forma de pago</b></td>
                <td align="center"><b>Ver recibo</b></td>
            </tr>
            </thead>
            <tbody>
              <?php
while ($row = mysql_fetch_assoc($datos)) {
    $acumulador= $row['entrada']-$row['salida'];
    $html.= '<tr> 
                <td>' .date_transform_lat($row['fecha']) . '</td>
                <td>' . $row['tipo_moneda'] . '</td>
                <td>' . $row['monto'] . '</td>
                <td>' . $row['concepto'] . '</td>
                <td>' . $row['forma_pago'] . '</td>
                <td><a href="javascript:verrecibo(' .$row['id'] . ')" class="btn btn-primary btn-xs"> Ver recibo</a></td>
                </tr>';
}



echo $html.= " </tbody> </table>";

?>


</tr>
</tr>
</tr>
</tr>
</table>
</div>
</form>
</div>
</div>
</div>
</td>
</tr>
</table>
</div>


            <script>







                var validacion = false;
                var id_usuario = '<?= $_SESSION['usuario_id']; ?>';
                function abrir_pop() {
                    $(".contra").val("");
                    $('#abrir').click();
                }





                function cambiar_contra() {
                    var nuevo = $('#nueva').val();
                    var repetir = $('#repetir').val();
                    var actual= $('#actual').val();
                    $('#tabla_repetir font').remove();
                    if (nuevo !== repetir) {
                        $('#tabla_repetir').append("<font style='color: red'> Las contrase&ntilde;as no coinciden</font>");
                        return false
                    } else
                    {

                        $.post('cambiar_contra.php', {nueva: nuevo, usuario: id_usuario, actual: actual, repetir:repetir}, function (d) {
                                console.log(d.operacion);
                            if(d.operacion){

                                alert('Contraseña modificada satisfactoriamente');
                                $("#close").click();
                            }
                            else{
                                    alert(d.mensaje);

                            }

                        },'json');
                        return true;
                    }


                }




                $('#cambiar_contrasenia').submit(function () {

                    if (cambiar_contra() && validacion) {

                        $('#close').click();
                        $('#nueva').val('');
                        $('#repetir').val('');
                        $('#actual').val('');

                        return true
                    }
                    return false;
                })





            </script>