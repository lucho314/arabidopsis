<?php
// DataTables PHP library

include( "datatable/php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;


$id=$_POST['usuarioNivel'];
$value=($id==2)? 1:2;
$condicion=($id==2)? '=':'<>';
/*
 * Example PHP implementation used for the join.html example
 */
Editor::inst( $db, 'archivos' )
	->field( 
		Field::inst( 'archivos.id' ),
		Field::inst( 'archivos.fecha_alta' ),
		Field::inst( 'archivos.nombre' ),
		Field::inst( 'archivos.descripcion' ),
		Field::inst( 'archivos.visible_colaborador' ),
		Field::inst( 'usuarios.nombre' )
	)
	->leftJoin( 'usuarios', 'usuarios.id', '=', 'archivos.usuario_alta' )
	->where('archivos.visible_colaborador',$value,$condicion)
	->process($_POST)
	->json();
