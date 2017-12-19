<?php

include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
include_once('html_sup.php');
?>

<div class="panel panel-primary" id="panel">
	<div class="panel-heading">
		<h3 class="panel-title">Formulario de carga de datos: <strong>RUBRO</strong></h3>
	</div>
	<div class="panel-body">
		<form action="/Arabidopsis/rubros.php#" method="POST" name="crear_" id="crear_" enctype="multipart/form-data" onsubmit="return creardescripcion()"><input type="hidden" name="variablecontrolposnavegacion" value="create">
			<table id="scaffold" class="table table-bordered table-striped" cellpadding="2" cellspacing="0" border="0" width="80%">
				<tbody>
					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Tipo Movimiento:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<select class="js-example-basic-single"> class="js-example-basic-single">
						  		<option>Seleccione tipo movimiento</option>
						  	</select>
						  </td>
					</tr>
					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Tipo Movimiento:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<select class="js-example-basic-single">>
						  		<option>Seleccione tipo movimiento</option>
						  	</select>
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Evento:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<select class="js-example-basic-single">>
						  		<option>Seleccione evento</option>
						  	</select>
						  </td>
					</tr>



					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Fecha:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<input type="text" size="35" name="fecha" class="datepicker">
						  </td>
					</tr>


					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Fecha:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<input type="text" size="35" name="fecha" class="datepicker">
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Colaborador:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<select class="js-example-basic-single">>
						  		<option>Seleccione colaborador</option>
						  	</select>
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Producto:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<select class="js-example-basic-single">>
						  		<option>Seleccione producto</option>
						  	</select>
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Monto:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<input type="number" name="monto">
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Tipo Moneda:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<select class="js-example-basic-single">>
						  		<option>Seleccione tipo moneda</option>
						  	</select>
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Monto En Pesos:</strong>
						 </td>
						  <td class="tabla_descripcion">
						  	<input type="text" size="35" id="pesos" disabled="disabled">
						  </td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Forma De Pago 1:</strong>
						 </td>
						  <td class="tabla_descripcion">
						 <select class="js-example-basic-single">>
						 	<option>Seleccione forma de pago</option>
						 </select>
						</td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Forma De Pago 2:</strong>
						 </td>
						  <td class="tabla_descripcion">
						 <select class="js-example-basic-single"> disabled="disabled">
						 	<option>Seleccione forma de pago</option>
						 </select>
						</td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Forma De Pago 3:</strong>
						 </td>
						  <td class="tabla_descripcion">
						 <select class="js-example-basic-single"> disabled="disabled">
						 	<option>Seleccione forma de pago</option>
						 </select>
						</td>
					</tr>


					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Nro Recibo Fundacion:</strong>
						 </td>
						  <td class="tabla_descripcion">
						 	<input type="text" size="35" name="nro_recibo">
						</td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Nro Recibo Manual:</strong>
						 </td>
						  <td class="tabla_descripcion">
						 	<input type="text" size="35" name="nro_recibo_manual">
						</td>
					</tr>

					<tr>
						<td width="150" align="right" class="tabla_descripcion">
							<strong>Observaciones:</strong>
						 </td>
						  <td class="tabla_descripcion">
						 	<input type="text" size="35" name="observaciones">
						</td>
					</tr>



					<tr>
					  	</tr><tr><td>&nbsp;</td>
                    <td align="center">
                          
                          <input type="hidden" name="campo" id="campo" value="rubros_id">
			  <input type="submit" value="Agregar registro "></td></tr></tbody></table></form></div></div>




<?php include 'html_inf.php'; ?>