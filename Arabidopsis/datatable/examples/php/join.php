<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;


/*
 * Example PHP implementation used for the join.html example
 */
Editor::inst( $db, 'archivos' )
	->field( 
		Field::inst( 'archivos.id' ),
		Field::inst( 'archivos.fecha_alta' ),
		Field::inst( 'archivos.nombre' ),
		Field::inst( 'archivos.usuario_alta' )
			->options( Options::inst()
				->table( 'usuarios' )
				->value( 'id' )
				->label( 'nombre' )
			)
			->validator( 'Validate::dbValues' ),
		Field::inst( 'usuarios.nombre' )
	)
	->leftJoin( 'usuarios', 'usuarios.id', '=', 'archivos.usuario_alta' )
	->process($_POST)
	->json();
