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
 Editor::inst( $db, 'reporte_contable' )
	->field( 
		Field::inst( 'reporte_contable.proveedor'),
		Field::inst( 'reporte_contable.concepto'),
		Field::inst( 'reporte_contable.nro_factura'),
		Field::inst( 'reporte_contable.nro_comprobante_o_transaccion'),
		Field::inst( 'reporte_contable.forma_de_pago'),
		Field::inst( 'reporte_contable.monto' ),
		Field::inst( 'reporte_contable.pagado'),
		Field::inst( 'reporte_contable.fecha'),
		Field::inst( 'reporte_contable.tipo_pago')
	)
	->where("reporte_contable.pagado","","!=")
	->process($_POST)
	->json();