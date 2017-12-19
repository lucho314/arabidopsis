
<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup_min.php');
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
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
</td>
</tr>
</TABLE>
</div>
</div>

<form method="post" target="_blank" id="verrecibo" action="imprimir_comprobante.php">
    <input type="hidden" name="id" id="id_genera_recibo">
    <input type="hidden" name="apertura" value="pre">
</form>

<div class="container-fluid"> 
<table class="table" width="80" height="50" align="center" cellpadding="8" cellspacing="0" border="0" style="background-color: #cccccc;">

    <tr>
        <td colspan="2">

            <table class="table table-bordered" align="center" width="1100" bgcolor="#ffffff">
                <tr>
                    <td align="left" width="125">
                        <a href="menu_principal.php">
                            <img src="images/logo.png" width="400">
                        </a>
                    </td>
                    <td width="600" align="right">
                        <div align="center"><strong><h3>SISTEMA DE CONSULTA COLABORADOR</h3></strong>
                             <a href="flujo_caja_colaborador.php">Flujo de caja</a>&nbsp;|
                            
                             <a href="javascript:abrir_pop()">Cambiar Contrase&ntilde;a</a>&nbsp;|

                             <a href="aut_logout.php">SALIR</a>
                        </div>
                    </td>
                    <td width="300" align="left">
                        <p style="text-decoration: blink;">
                            <img src="images/tips.jpg" align="right">
                            <?php
                            include_once('tips.php');
                            ?>
                        </p>
                    </td>
                </tr>
            </table>



        </td></tr>



    <tr>

        <td align="center" valign="top">
            <br>

            <!-- Trigger the modal with a button -->
            <button type="button" id="abrir" style="display: none" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cambio de Contrase&ntilde;a</h4>
                            
                        </div>
                        <form action="#" id="cambiar_contrasenia">
                            <div class="modal-body">
                                <table id="scaffold" class="table table-bordered table-striped" cellpadding="2" cellspacing="0" border="0" width="80%">
                                    <tr>
                                        <td align="right"  width="200"> <b>Contrase&ntilde;a actual:</b></td><td id='tabla_actual'><input id='actual' type="password" class='contra'></td>
                                    </tr>
                                    <tr>
                                        <td align="right"  width="200"><b>Nueva contrase&ntilde;a:</b></td><td id='tabla_nueva'> <input id="nueva" type="password" class='contra'><br></td>
                                    </tr>
                                    <tr>
                                        <td align="right"  width="200"><b>Repetir nueva contrase&ntilde;a:</b></td><td id='tabla_repetir'> <input id="repetir" type="password" class='contra'><br></td>
                                    <tr>
                                    <tr>
                                        <td></td><td> <input type="submit" value="Aceptar"><br></td>
                                    <tr>
                                </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cerrar"  id='close' data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
            </div>
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