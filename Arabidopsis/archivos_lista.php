
	<?php
	$usuarioNivel= $_SESSION['usuario_nivel'];
	?>
<div class="panel panel-primary">
	
	      <div class="panel-heading">Listado de archivos</div>
	      <div class="panel-body">

<table class="table" id="archivoss" width="100%">
	<thead>
		<tr>
			<th>Nombre archivo</th>
			<th>Descripcion</th>
			<th>Fecha de alta</th>
			<th>Usuario alta</th>
			<th>Visible colaborador</th>
			<th>Acciones</th>
		</tr>
	</thead>
</table>
</div>
</div>

<script type="text/javascript">

var table=$('#archivoss').DataTable( {
		//dom: "Bfrtip",
		ajax: {
			url: "archivoServiceSide.php",
			type: 'POST',
			data:function(data){
				data['usuarioNivel']=<?=$usuarioNivel; ?>;
				return data;
			}
		},
		"columnDefs": [
            { "orderable": false,"searchable": false, "targets": 5 },
          
            ],
		serverSide: true,
		processing: true,
		columns: [
			{ data: "archivos.nombre" },
			{ data: "archivos.descripcion" },
			{ data: "archivos.fecha_alta" },
			{ data: "usuarios.nombre" },
			{data:'archivos.visible_colaborador',
				render:function(data){
					return (data==1)?'Activo':'desactivado';
				}
			},

			{data:function(data){
				var accion=(data.archivos.visible_colaborador==1)?'Desactivar' : 'Activar';
				var html='<button class="btn btn-primary btn-xs" onclick="cambiarEstado('+data.archivos.visible_colaborador+','+data.archivos.id+')">'+accion+'</button>&nbsp;';
				html+='<a  href="uploads/'+data.archivos.nombre+'" class="btn btn-default btn-xs" download>Descargar</a>';
				return html;
			}}
		]
} );


function cambiarEstado(visible,id){
	
	console.log(visible);
	if(!visible)
	{
		alert('desactivar');

	}
	else{
		alert("activar");
	}
	 $.post('ajaxArchivos.php',{id:id},function(data){
			console.log(data);
		},'json');

	table.ajax.reload();

}
</script>
