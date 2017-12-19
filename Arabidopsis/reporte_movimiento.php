<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
include_once('html_sup.php');


$sql="
SELECT m.id, tm.descripcion as movimiento,c.descripcion concepto,DATE_FORMAT(m.fecha,'%d-%m-%Y') as fecha, fecha as f,m.monto_en_pesos as monto,tt.descripcion as 'tipo_transaccion', 
(case m.tipo_movimiento_id when 1 then cl.razon_social else pr.razon_social end) as prov_col,
(case m.forma_de_pago_id when 2 then fp.descripcion 
   when 3 then ''
    when 4 then concat(fp.descripcion,' ' ,bc.descripcion) 
    when 5 then concat(fp.descripcion,' ' ,tj.descripcion) 
    end 
) as 'forma_pago', m.observaciones 
FROM movimientos m   
INNER JOIN tipo_movimientos tm on tm.id=m.tipo_movimiento_id   
INNER JOIN forma_de_pagos fp on fp.id=m.forma_de_pago_id  
INNER JOIN tipo_de_transaccions tt on tt.id=m.tipo_de_transaccion_id  
INNER JOIN concepto_movimientos c on c.id=m.concepto_movimiento_id  
INNER JOIN colaboradors cl on cl.id=m.colaborador_id  
INNER JOIN proveedors pr  on pr.id=m.proveedor_id 
INNER JOIN bancos bc  on bc.id=m.banco_id 
INNER JOIN tarjeta_de_creditos tj  on tj.id=m.tarjeta_de_credito_id";


$safePost = filter_input_array(INPUT_GET,FILTER_SANITIZE_ENCODED);
$q=urldecode(isset($safePost['q']) ? $safePost['q']: '');


$filter=array_filter(explode(' ', $q),'strlen');


if(count($filter)>0){

	$sql.=' WHERE ';
	foreach ($filter as $value) {
	 $value=trim($value);
	 $sql.="(tm.descripcion LIKE '%$value%' OR 
			DATE_FORMAT(m.fecha,'%d-%m-%Y') LIKE '%$value%' OR 
			m.monto_en_pesos LIKE '%$value%' OR 
			fp.descripcion LIKE '%$value%' OR 
            c.descripcion  LIKE '%$value%' OR 
            cl.razon_social  LIKE '%$value%' OR 
            pr.razon_social  LIKE '%$value%' OR 
            m.observaciones  LIKE '%$value%' OR 
			tt.descripcion LIKE '%$value%') and ";
			}

	$sql=substr($sql, 0,-4);
}


$mostrar=(isset($safePost['mostrar']))?$safePost['mostrar'] :50 ;

$campoOrder=(isset($safePost['campoOrdenar']))?$safePost['campoOrdenar'] : 'fecha' ;

$tipoOrdenar= (isset($safePost['tipoOrder']))?$safePost['tipoOrder'] : 'asc' ;


$campoOrder=($campoOrder=='fecha')? 'f' : $campoOrder;

 $sql.=" order by $campoOrder $tipoOrdenar LIMIT ".$mostrar;


$datos = mysql_query($sql);

$filas=mysql_affected_rows();

?>


 
<body>

<div class="text-center" style="
    margin-bottom: 25px;">
   <?= $filas?> Registro/s encontrado/s.<br>
        Sección: MOVIMIENTO
</div>
<form action="#" method="get">
      <div style="margin-right: 74%" class="form-inline">
               <div class="col-md-4">
                <label style=" margin-top: 3px;">Mostrando</label>
            </div>
            <div class="col-md-8">
                <select name="mostrar" onchange="$('form').submit()" id="mostrando">
                    <option value="10" <?= ($mostrar=='10')? 'selected' : ''?> >10</option>
                    <option value="20" <?= ($mostrar=='20')? 'selected' : ''?>>20</option>
                      <option value="50" <?= ($mostrar=='50')? 'selected' : ''?>>50</option>
                    <option value="100" <?= ($mostrar=='100')? 'selected' : ''?>>100</option>
                    <option value="200" <?= ($mostrar=='200')? 'selected' : ''?>>200</option>
                    <option value="500" <?= ($mostrar=='500')? 'selected' : ''?>>500</option>
                     <option value="1000" <?= ($mostrar=='1000')? 'selected' : ''?>>1000</option>
                      <option value="999999999" <?= ($mostrar=='999999999')? 'selected' : ''?>>Todos</option>
                </select>
                <input type="hidden" name="campoOrdenar" id="campoOrder" value="<?= $campoOrder?>">
                <input type="hidden" name="tipoOrder" id="tipoOrder" value="<?= $tipoOrdenar?>">
                <a href="javascript:excel()" style="margin-left: 6px;" class="btn btn-default">Excel</a>
            </div>
        </div>  
         <div style="margin-left: 70%;" class="form-inline">
            <label>Buscar:</label>
            <input type="text" name="q" class="form-control" style="width: 74%" value="<?= $q?>">
        </div>
     </form>  
        <div class="panel panel-primary" style="width: 100%" >

        <table class="table table-striped dataTable no-footer" id="lista" cellpadding="2" cellspacing="0" border="0" role="grid" aria-describedby="lista_info">
       <thead>
            <tr>
                
                <td colspan="1" rowspan="1" id="fecha"><b><a href="#" class="ordenar" order='asc' campo='fecha'>Fecha</a></b></td>
                <td colspan="1" rowspan="1" id="movimiento"><b><a href="#" class="ordenar" order='asc' campo='movimiento'>Movimiento</a></b></td>
                <td colspan="1" rowspan="1" id="concepto"><b><a href="#" class="ordenar" order='asc' campo='concepto'>Concepto</a></b></td>
                <td colspan="1" rowspan="1" id="monto"><b><a href="#" class="ordenar" order='asc' campo='monto'>Monto</a></b></td>
                 <td colspan="1" rowspan="1" id="prov_col"><b><a href="#" class="ordenar" order='asc' campo='prov_col'>Colaborador/Proveedor</a></b></td>
                <td colspan="1" rowspan="1" id="forma_pago"><b><a href="#" class="ordenar" order='asc' campo='forma_pago'>Forma de pago</a></b></td>
                <td colspan="1" rowspan="1" id="tipo_transaccion"><b><a href="#" class="ordenar" order='asc' campo='tipo_transaccion'>Tipo de transaccion</a></b></td>
                <td colspan="1" rowspan="1" id="observaciones"><b><a href="#" class="ordenar" order='asc' campo='observaciones'>Observaciones</a></b></td>
             </tr>
             </thead>
             <?php  while ($value = mysql_fetch_assoc($datos)): $total+=$value['monto']; ?>
            
             	<tr>
                    <td align="center"><?= $value['fecha']?></td>
             		<td align="center"><?= $value['movimiento']?></td>
                    <td align="center"><?= $value['concepto']?></td>
             		<td align="center"><?= $value['monto']?></td>
                    <td align="center"><?= $value['prov_col']?></td>
             		<td align="center"><?= $value['forma_pago']?></td>
             		<td align="center"><?= $value['tipo_transaccion']?></td>
                    <td align="center"><?= $value['observaciones']?></td>

             	</tr>
             <?php endwhile ?>

             <tr>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"><b>TOTAL<b></td>
                    <td align="center"><b><?= $total?><b></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
              

                </tr>
         </table>

</div>

<script type="text/javascript">
    
$(function(){

    campo= "<?=$campoOrder?>";
    tipoOrder= "<?= $tipoOrdenar?>";
    ordenar='sorting_'+tipoOrder;
    $('#'+campo).addClass(ordenar);


})

function excel(){
    sql=<?=json_encode($sql)?>; 
    console.log(sql);
     window.open('exportar_a_excel.php?sql='+sql );
 }
   

$('.ordenar').click(function(){
    order=$(this).attr('order');
    campo=$(this).attr('campo');

    Norder=(order=='asc')? 'desc' : 'asc';
    $(this).attr('order',Norder);
   $('#campoOrder').val(campo);
   $('#tipoOrder').val(order);
   $('form').submit();

})

</script>

<?php include 'html_inf.php';