<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
include_once('html_sup.php');
$id_forma_pago = (isset($_REQUEST['forma_pago'])) ? $_REQUEST['forma_pago'] : false;
$fecha_inicio = date_transform_usa($_REQUEST['fecha_inicio']);
$fecha_fin = date_transform_usa($_REQUEST['fecha_fin']);


$flujo = DevuelveValor($id_forma_pago, 'descripcion', 'forma_de_pagos', 'id');

$sql="select fecha,descripcion,flujo,entrada,salida,'' as saldo from
                (select fecha,ct.descripcion,forma_de_pago_id,monto as entrada,'' as salida,m.tipo_movimiento_id , fp.descripcion as 'flujo' from movimientos as m 
                INNER JOIN forma_de_pagos fp on fp.id=m.forma_de_pago_id  
                INNER JOIN concepto_movimientos ct on ct.id=m.concepto_movimiento_id   
                where m.tipo_movimiento_id=1  
                union 
                select fecha,ct.descripcion,forma_de_pago_id,'' as entrada,monto as salida,m.tipo_movimiento_id, fp.descripcion as 'flujo' from movimientos as m 
                INNER JOIN forma_de_pagos fp on fp.id=m.forma_de_pago_id 
                INNER JOIN concepto_movimientos ct on ct.id=m.concepto_movimiento_id   
                where m.tipo_movimiento_id=2 
                ) as alias 
        WHERE fecha BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_fin . "' ";

//echo $slq;





$sql_forma_pago = "select id, descripcion from forma_de_pagos
                    union
                    select 99,'TODOS'";
    $formas_pagos = mysql_query($sql_forma_pago);

if ($id_forma_pago != false && $id_forma_pago!=99) {
    
    $sql .= " and forma_de_pago_id=" . $id_forma_pago;
}
 $sql .=" ORDER BY fecha ";

$datos = mysql_query($sql);


echo $head = "<html>
    <head>
        <title>
            Reporte
        </title></head>
        ";
?>
<div class="panel panel-primary" style="width: 100%" >
    <div class="panel-heading">
        <h3 class="panel-title"><?= ($id_forma_pago != false) ? 'Seleccione Fecha y Flujo' : 'Seleccione Fecha' ?></h3>
    </div>
    <table width="100%" style="text-align:center;">
        <tr><td>  &nbsp; </td></tr>
        <tr>
        <form action="libro_diario.php" method="post">
            <td><b>Fecha Inicio: </b></td>
            <td><input type="text" name="fecha_inicio" id="fecha_inicio" value="<?= $_REQUEST['fecha_inicio'] ?>" class="datepicker"></td>
            <td><b>Fecha fin</td>
            <td><input type="text" name="fecha_fin" id="fecha_fin" value="<?= $_REQUEST['fecha_fin'] ?>" class="datepicker"></td>
            <?php if ($id_forma_pago != false): ?>
                <td><div class="form-inline"><b>Flujo</b> <select class="js-example-basic-single"  id="flujo_" name="forma_pago" > <?php
                            while ($row1 = mysql_fetch_array($formas_pagos)) {
                                if ($row1[0] == $id_forma_pago)
                                    echo "<option value=" . $row1[0] . " selected>" . $row1[1] . "</option>";
                                else if ($row1[0] == 1) {
                                    
                                } else
                                    echo "<option value=" . $row1[0] . ">" . $row1[1] . "</option>";
                            }
                            ?> </select></div>
                </td>
            <?php endif; ?>
            <td><input type="submit" class="btn btn-primary" value="Actualizar"></td> 

            </tr>
        </form>
    </table>
</div>



<?php
$html = '
<body bgcolor=\"#ffffff\">
    <div style=\"margin:30px;\">
    <a href="javascript:excel()" style="margin-right: 94%;" class="btn btn-default">Excel</a>
        <table width="100%" border="1" class="table table-striped table-responsive" id="flujo">
       
            <tr>
                <td align="center"><b>Fecha</b></td>

                <td align="center"><b>Descripcion</b></td>
                 <td align="center"><b>Forma de pago</b></td>';
                $html.='<td align="center"><b>Entrada</b></td>
                <td align="center"><b>Salida</b></td>
                <td align="center"><b>Saldo</b></td>';

$html.='</tr>';
while ($row = mysql_fetch_assoc($datos)) {
    $acumulador+= $row['entrada']-$row['salida'];
    $html.= '<tr> 
                <td align="center">' . date_transform_lat($row['fecha']) . ' </td>
                <td align="center">' . $row['descripcion'] . '</td>
                <td align="center">' . $row['flujo'] . '</td>
                <td align="center">' . $row['entrada'] . '</td>
                <td align="center">' . $row['salida'] . '</td>
                <td align="center">' . $acumulador . '</td>
                </tr>';
}
$total = $acumulador_entrada - $acumulador_salida;


$html.= "  </table>
    </div>";
echo $html;
echo $foot = "</body></html>";
if ($id_forma_pago != false) {
    $texto = 'Reporte Flujo ' . $flujo;
} else {
    $texto = 'Libro diario';
}
?>

Acciones PDF:
<table align="center" width="200"  style="padding-left: 10px;">
    <tr>
        <td align="center">
            <form action="imprime_pdf.php" method="post" name="exportapdf" target="_blank">
                <input type="hidden" name="html" value="<?php echo base64_encode($html); ?>">
                <input type="hidden" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
                <input type="hidden" name="texto" value="<?php echo $texto; ?>">
                <input type="hidden" name="fecha_fin" value="<?php echo $fecha_fin; ?>"> 
                <input type="hidden" name="personal_id" value="<?php echo $id_personal; ?>">   
                <input type="hidden" name="estado_id" value="<?php echo $estado_id; ?>">
                <input type="hidden" name="tipo_de_reporte" value="<?php echo $tipo_de_reporte; ?>">
                <input type="hidden" name="tipo_reporte" value="viatico_maestros"> 
                <input type="hidden" name="apertura" value="ver">   
                <input type="submit" name="submit" value="Ver ">
            </form>            
        </td>
        &nbsp;
        <td align="center">
        <td align="center">
            <form action="elegir_colaborador.php" method="post" name="exportapdf" target="_blank">
                <input type="hidden" name="html" value="<?php echo base64_encode($html); ?>">
                <input type="hidden" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
                <input type="hidden" name="texto" value="<?php echo $texto; ?>">
                <input type="hidden" name="fecha_fin" value="<?php echo $fecha_fin; ?>"> 
                <input type="hidden" name="apertura" value="enviar">   
                <input type="hidden" name="estado_id" value="<?php echo $estado_id; ?>">
                <input type="hidden" name="tipo_de_reporte" value="<?php echo $tipo_de_reporte; ?>">
                <input type="hidden" name="tipo_reporte" value="viatico_maestros">      
                <input type="submit" name="submit" title="Se envia a  colaboradores especificos el resumen como pdf" value="Enviar ">
            </form>            
        </td>         


    </tr>

</table>



</body>
</html>
<?php include_once('html_inf.php'); ?>

<script type="text/javascript">
    

    function excel(){
    sql=<?=json_encode($sql)?>; 

     window.open('exportar_a_excel_flujo.php?sql='+sql );
 }
</script>