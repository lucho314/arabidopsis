
<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup_min.php');
include_once('lib/connect_mysql.php');

$date = new DateTime();
$mostrar=new DateTime();
$fechaActual=new DateTime();

if($fechaActual->format("d")==31)
{
    $fechaActual->modify('-1 day');
    $date->modify('-1 day');
    $mostrar->modify('-1 day');
}

$mostrar->modify("-6 months");
$date->modify('-6 months');
$fechaActual->modify('-1 months');

for($i=0; $i<6; $i++){
 $sql="select sum(monto) as monto, cp.descripcion from movimientos m
left join concepto_movimientos cp on cp.id=m.concepto_movimiento_id 
 where m.tipo_movimiento_id=1 and date_format(fecha,'%Y/%m')='".$date->format("Y/m")."' group by descripcion";
$query=mysql_query($sql);
while ($row = mysql_fetch_assoc($query)) {
    $datos[$date->format("m/Y")]["entrada"][]=$row;
}

 $sql="select sum(case when forma_de_pago_id<>5 then monto else 0 end) monto, cp.descripcion from movimientos m
left join concepto_movimientos cp on cp.id=m.concepto_movimiento_id 
 where m.tipo_movimiento_id=2 and date_format(fecha,'%Y/%m')='".$date->format("Y/m")."' group by descripcion";
$query=mysql_query($sql);
while ($row = mysql_fetch_assoc($query)) {
    $datos[$date->format("m/Y")]["salida"][]=$row;
}

$date->modify('+1 month');

}



?>
<script>
    $(function () {

        $('#lista').DataTable({
           "bSort": false,
            "bPaginate": false,
            dom: 'Brtip',
            buttons: [
                'pdf', 'excel'

            ],
            "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            }
        })
    })

</script>

            <p><b>En esta seccion podra ver el flujo de caja periodo <?= $mostrar->format("m/Y"); ?> - <?= $fechaActual->format("m/Y"); ?> </b></p>


              <table width="100%" border="1" class="table table-striped table-responsive" id="lista">
       <thead>
            <tr>
                <td align="center"><b>Periodo</b></td>
                <td align="center"><b>Descripcion</b></td>
                <td align="center"><b>Entrada</b></td>
                <td align="center"><b>Salida</b></td>
                <td align="center"><b>Saldo</b></td>
            </tr>

        </thead>
        <tbody>


            <?php
foreach ($datos as $key => $value) {


    $html.= "<tr><td align='right'>$key</td>
    <td></td><td></td><td></td><td></td>

    </tr>";
   
    $salidas=0;
    $entradas=0;
    foreach ($value["entrada"] as $row) {
        $entradas+=$row['monto'];
        $html.= '<tr> 
                <td></td>
                <td align="center">' .$row['descripcion'] . '</td>
                <td align="center">X</td>
                <td align="center"></td>
                <td align="center"></td>
                ';
    }

    foreach ($value["salida"] as $row) {
        $salidas+=$row['monto'];
        $html.= '<tr> 
                <td></td>
                <td align="center">' .$row['descripcion'] . '</td>
                <td align="center"></td>
                <td align="center">X</td>
                <td align="center"></td>
                </tr>';
    }
     $html.= "<tr><td></td>
            <td align='center'>TOTAL</td>
            <td align='center'>$entradas</td>
            <td align='center'>$salidas</td>
            <td align='center'>".($entradas-$salidas)."</td>
            </tr>";

    # code...
}
    /*$acumulador= $row['entrada']-$row['salida'];
   ;*/



echo $html.= "  </tbody></table>";

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




                $('form').submit(function () {

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