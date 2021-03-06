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
 Editor::inst( $db, 'movimientos' )
    ->field( 
        Field::inst( 'concepto_movimientos.descripcion'),
        Field::inst( 'movimientos.descripcion'),
        Field::inst( 'movimientos.fecha'),
        Field::inst( 'proveedors.razon_social' ),
        Field::inst( 'movimientos.monto_en_pesos'),
        Field::inst( 'movimientos.nro_factura'),
        Field::inst( 'movimientos.nro_comprobante_o_transaccion'),
        Field::inst( 'movimientos.observaciones'),
        Field::inst( 'archivos.nombre'),
        Field::inst( 'movimientos.id')
    )
    ->leftJoin( 'concepto_movimientos', 'concepto_movimientos.id', '=', 'movimientos.concepto_movimiento_id')
    ->leftJoin( 'proveedors', 'proveedors.id', '=', 'movimientos.proveedor_id')
    ->leftJoin( 'archivos', 'archivos.descripcion', '=', 'concat("Movimiento","_",movimientos.id)')
    ->where("movimientos.tipo_movimiento_id","2")
    ->process($_POST)
    ->json();