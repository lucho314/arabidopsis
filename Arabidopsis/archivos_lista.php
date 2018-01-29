
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
			<?php if($usuarioNivel==1): ?>
				<th>Usuario alta</th>
				<th>Visible colaborador</th>
			<?php endif; ?>
			<th>Acciones</th>
		</tr>
	</thead>
</table>
</div>
</div>

<script type="text/javascript">
usuarioNivel=<?= $usuarioNivel?>;
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
            { "orderable": false,"searchable": false, "targets": (usuarioNivel==1)?5:3 },
          
            ],
		serverSide: true,
		processing: true,
		columns: [
			{ data: "archivos.nombre" },
			{ data: "archivos.descripcion" },
			{ data: "archivos.fecha_alta" },
			<?php if($usuarioNivel==1): ?>
			{ data: "usuarios.nombre" },
			{data:'archivos.visible_colaborador',
				render:function(data){
					return (data==1)?'Activo':'desactivado';
				}
			},
			<?php endif; ?>

			{data:function(data){
				var accion=(data.archivos.visible_colaborador==1)?'Desactivar' : 'Activar';
				if(usuarioNivel==1){
						var html='<button class="btn btn-primary btn-xs" onclick="cambiarEstado('+data.archivos.visible_colaborador+','+data.archivos.id+')">'+accion+'</button>&nbsp;';
				html+='<a  href="uploads/'+data.archivos.nombre+'" class="btn btn-default btn-xs" download>Descargar</a>';
				}
				else{
					var html='<a  href="uploads/'+data.archivos.nombre+'" class="btn btn-default btn-xs" download>Descargar</a>';
				}
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
