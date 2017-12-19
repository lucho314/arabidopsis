<?php
$tip = '';

include_once('html_sup.php');


include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    var x = document.getElementById("producto_id").selectedIndex;
    var y = document.getElementById("producto_id").options;
    
    valor = y[x].text;     
        
    if (valor === 'GENERICO') {
        valor = document.getElementById('detalle').value;
    }

    descripcion = valor;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
<?php
new Scaffold(
        "noeditable",
        "factura_detalles",
        3000000,
        array('descripcion','cantidad','producto_id','precio_unitario','iva_id'),
        array(),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        );


//Leo los datos almacenados en los detalles y calculo los totales.
$maestro_id = $_POST['maestro_id'];
$abono_id   = $_POST['abono_id'];
$mes_abono  = $_POST['mes_abono'];
$anio_abono = $_POST['anio_abono'];


//Tomo los datos de cantidad, monto e iva de cada registro y calculo los totales correspondientes.
$sql = "SELECT * 
            FROM  `factura_detalles` 
            WHERE  `factura_maestro_id` = $maestro_id";
$consulta = mysql_query($sql,$link);

while($fila = mysql_fetch_array($consulta, MYSQL_BOTH)){
    $cantidad           = $fila['cantidad'];
    $monto_unitario     = $fila['precio_unitario'];
    $tipo_de_iva        = $fila['iva_id'];
    $iva = DevuelveValor($tipo_de_iva,'descripcion','ivas','id');

    $monto_x_cantidad = $cantidad * $monto_unitario;
    $iva = ($iva/100)+1;
    

    
    $monto_con_iva = $monto_x_cantidad*$iva;
    $monto_iva = $monto_con_iva - $monto_x_cantidad;
    
    if ($iva == "1.21") $iva_21 = $iva_21 + $monto_iva;
    else $iva_105 = $iva_105 + $monto_iva;    
    
    $monto_acumulado = $monto_con_iva + $monto_acumulado;
    
    $total_impuestos = $total_impuestos + $monto_iva;
    $total_sin_impuestos = $total_sin_impuestos + $monto_x_cantidad;
}

//Actualizo los datos en el maestro.

$sql_update = "UPDATE `factura_maestros` SET "
        . "`control`='1',"
        . "`subtotal`='$total_sin_impuestos',"
        . "`impuesto`='0',"
        . "`iva_21`='$iva_21',"
        . "`iva_105`='$iva_105',"
        . "`total`=$monto_acumulado,"
        . "`anulada`='0'"
        . " WHERE id='$maestro_id'";
mysql_query($sql_update);

//echo $sql_update;


echo "<br><br><strong>Total de impuestos: </strong>".round($total_impuestos,2);
echo "<br><strong>Total SIN impuestos: </strong>".round($total_sin_impuestos,2);
echo "<br><strong>Total: </strong>".$monto_acumulado;

$dato = $maestro_id;
//Me fijo si se registró e imprimió el pago correspondiente:
//
/*
$sql_registro = "SELECT * FROM registro_de_pagos 
                    WHERE emitida = 0 
                    AND fecha_emitida = '2001-01-01' 
                    AND abono_id = $abono_id";
$consulta_registro = mysql_query($sql_registro);
$numero_filas = mysql_num_rows($consulta_registro);
$fecha_actual = date('Y-m-d');
*/





//Ahora genero el formulario para enviar los datos al que se encargará 
//de guardarlos y actualizar el registro correspondiente.
?>
<br><br>
<form method="POST" action="imprimir_comprobante.php" target="_blank">
  <input type="hidden" name="dato" value='<?php echo $dato ?>'>
  <input type="submit" value="Imprimir">
</form>



<?php

include_once('html_inf.php');
?>