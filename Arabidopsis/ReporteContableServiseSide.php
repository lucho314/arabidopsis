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


/*
 * Example PHP implementation used for the join.html example
 */
 Editor::inst( $db, 'reporte_contable_full' )
	->field( 
		Field::inst( 'reporte_contable_full.persona'),
		Field::inst( 'reporte_contable_full.concepto'),
		Field::inst( 'reporte_contable_full.nro_factura'),
		Field::inst( 'reporte_contable_full.forma_de_pago'),
		Field::inst( 'reporte_contable_full.pagado'),
		Field::inst( 'reporte_contable_full.fecha'),
		Field::inst( 'reporte_contable_full.tipo_pago'),
		Field::inst( 'reporte_contable_full.tipo_movimiento')
		
	)
	->where("reporte_contable_full.pagado","","!=")
	->process($_POST)
	->json();