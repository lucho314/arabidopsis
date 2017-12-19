<?php
if(!isset($_SESSION['postergar'])){
	$sql="SELECT * FROM tarjeta_de_creditos WHERE (date_format(`fecha_vencimiento`, '%Y-%m') <date_format(curdate(), '%Y-%m') or fecha_vencimiento is null) AND id<>1 and recargable=0";

	$result=mysql_query($sql);

	if(mysql_affected_rows()>0):?>

		<div id="modal_vencimientos_tarjeta" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" style="float: right;" id="postergar">Posponer</button>
			        <h4 class="modal-title">Fechas de vencimientos</h4>
			      </div>
			      <div class="modal-body">
			        <p>Se requieren las fechas de vencimientos de las siguientes tarjetas</p>
			        <form id="vencimientos_tarjeta">
			        <?php while ($value = mysql_fetch_assoc($result)): ?>
			        	<div class="form-inline">
			        		<label><?= $value["descripcion"] ?></label>
			        		<input class="form-control datepicker" type="text" name="fecha_vencimiento[<?= $value["id"] ?>]"></input>
			        	</div>

			        <?php endwhile;?>
			      </div>
			      </form>
			      <div class="modal-footer">
			      	 <button type="button" class="btn btn-success" id="aceptar">Aceptar</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>

		  </div>
		</div>
<script type="text/javascript">
	$(function(){
		$("#modal_vencimientos_tarjeta").modal({backdrop: 'static', keyboard: false},"toggle");
		$("#aceptar").click(function(){
			var data=$("#vencimientos_tarjeta").serialize();
			$.post("ajax_vencimientos_tarjeta.php",data,function(){
				$("#modal_vencimientos_tarjeta").modal("toggle");
			})

		})

		$("#postergar").click(function(){
			$.post("ajax_vencimientos_tarjeta.php",{postergar:1,session:"<?= $usuarios_sesion;?>"},function(){
				$("#modal_vencimientos_tarjeta").modal("toggle");
			})
		})

	})
</script>
<?php
else:

			if($_SESSION['postergar']==1)
			{

			}
	endif;


}
?>
