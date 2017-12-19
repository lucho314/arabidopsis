<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.css">
         <script type="text/javascript" language="javascript" src="DataTables-1.10.12/media/js/jquery.dataTables.js">
        </script>
        <link rel="stylesheet" href="bootstrap-3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="DataTables-1.10.12/media/css/jquery.dataTables.min.css">
         <link rel="stylesheet" href="DataTables-1.10.12/media/css/buttons.dataTables.min.css">
</head>
<body>

<h3>Lista de archivos</h3>

<table class="table" id="archivos">
	<thead>
		<tr>
			<th>Nombre archivo</th>
			<th>Descripcion</th>
			<th>Fecha de alta</th>
			<th>Usuario alta</th>
		</tr>
	</thead>
</table>

</body>

<script type="text/javascript">

$('#archivos').DataTable( {
		dom: "Bfrtip",
		ajax: {
			url: "archivoServiceSide.php",
			type: 'POST'
		},
		serverSide: true,
		columns: [
			{ data: "archivos.id" },
			{ data: "archivos.fecha_alta" },
			{ data: "archivos.nombre" },
			{ data: "usuarios.nombre" }
		]
} );

</script>
</html>