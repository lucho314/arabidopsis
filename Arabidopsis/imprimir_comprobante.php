<?php

require_once("tcpdf/tcpdf.php");
require_once("fpdi/fpdi.php");
//require_once 'enviar_mail.php';
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';
include_once('NumberToLetterConverter.php');


$pdf = new FPDI();
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Fundacion Impulso de una Nueva Vida');
$pdf->SetTitle('Recibo de pago');
$pdf->SetSubject('Recibo');
$pdf->SetKeywords('Recibo, Fundacion');
$pdf->setPDFVersion ($version='1.7');


$apertura = $_REQUEST['apertura'];

$nro_recibo_fundacion = "0004 - ";
// Fuente template
$pdf->setSourceFile("plantillapdf.pdf");
// tomamos la pagina 1
$tplIdx = $pdf->importPage(1);
// alineamos
$pdf->useTemplate($tplIdx);
//fuente
$pdf->SetFont('Helvetica');

$sql_movimiento = "SELECT "
                    . "monto,"
                    . "monto_en_pesos,"
                    . "nro_recibo_fundacion,"
                    . "concepto_movimiento_id,"
                    . "forma_de_pago_id,"
                    . "colaborador_id,"
                    . "observaciones,"
                    . "tipo_moneda_id,"
                    . "fecha"
                . " FROM "
                    . "movimientos "
                . "WHERE id=" . $_REQUEST['id'];

//echo $sql_movimiento;

$query_movimientos = mysql_query($sql_movimiento);
$datos_movieminto = mysql_fetch_array($query_movimientos);

$concepto = DevuelveValor($datos_movieminto[3], 'descripcion', 'concepto_movimientos', 'id');
$observaciones = $datos_movieminto[6];

$forma_de_pago_id = $datos_movieminto[4];
$forma_de_pago = DevuelveValor($forma_de_pago_id, 'descripcion', 'forma_de_pagos', 'id');

$fecha = $datos_movieminto['fecha'];

if (empty($fecha)) $fecha = date("d/m/y");
else 
{
    $fecha = date_transform_lat($fecha);
    $fecha = str_replace('-','/', $fecha);
}
    

$moneda = DevuelveValor($datos_movieminto[7], 'descripcion', 'tipo_monedas', 'id');

$sql_proveedor = "SELECT email,razon_social, cuit, domicilio, condicion_iva_id, telefono, "
        . " localidads.descripcion as localidad,provincias.descripcion as provincia,paiss.descripcion as pais "
        . "from colaboradors INNER JOIN localidads on localidads.id=colaboradors.localidad_id "
        . "INNER JOIN provincias on provincias.id=localidads.provincia_id "
        . "INNER JOIN paiss on paiss.id=provincias.pais_id"
        . " where colaboradors.id=$datos_movieminto[5]";
$query = mysql_query($sql_proveedor);
//echo $sql_proveedor;
while ($row = mysql_fetch_array($query)) {
    $razon_social = $row['razon_social'];
    //$razon_social = utf8_encode($razon_social);
    $cuit = $row['cuit'];
    $dir = $row['domicilio'] . " " . $row['localidad'] . " " . $row['provincia'] . " " . $row['pais'];
    $condicion_iva = DevuelveValor($row['condicion_iva_id'], 'descripcion', 'condicion_ivas', 'id');
    $telefono = $row['telefono'];
    $email = $row['email'];
}
$direccion = $dir;
//echo $direccion;
$array_fecha = explode('/', $fecha);
$numero_a_letra = new NumberToLetterConverter();
$monto_con_coma=str_replace('.',',',$datos_movieminto[0]);
//echo 
$monto_letras=$numero_a_letra->to_word($monto_con_coma);
//print_r($datos_movieminto);


$pdf->SetAutoPageBreak(True, PDF_MARGIN_FOOTER);


$pdf->SetFont('helvetica', 'B', 20);
$pdf->setXy(126, 25);
$pdf->Write(0, $nro_recibo_fundacion . $datos_movieminto[2]);
$pdf->SetFont('helvetica', '', 15);
$pdf->SetXY(164, 41);
$pdf->Write(0, $array_fecha[0]);
$pdf->SetXY(175, 41);
$pdf->Write(0, $array_fecha[1]);
$pdf->SetXY(185, 41);
$pdf->Write(0, $array_fecha[2]);

//$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 13);
$pdf->SetXY(63, 70);

$pdf->Write(0, $razon_social, '', 0, false, 'J', true, 0, false, false, 0);

$pdf->SetXY(28, 80);
$pdf->Write(0, $direccion);
$pdf->SetXY(14, 92);
$pdf->Write(0, $telefono, '', 0, false, 'J', true, 0, false, false, 0);
$pdf->SetXY(106, 92);
$pdf->Write(0, $email, '', 0, false, 'J', true, 0, false, false, 0);
$pdf->SetXY(14, 100);
$pdf->Write(0, $condicion_iva, '', 0, false, 'J', true, 0, false, false, 0);
$pdf->SetXY(120, 100);
$pdf->Write(0, 'CUIT: ' . $cuit, '', 0, false, 'J', true, 0, false, false, 0);

$pdf->SetXY(57, 115);
$pdf->Write(0, $monto_letras . " " . $moneda, '', 0, false, 'J', true, 0, false, false, 0);


$pdf->SetXY(46, 132);
$pdf->Write(0, $concepto, '', 0, false, 'J', true, 0, false, false, 0);

$pdf->SetXY(89, 234);
$pdf->Write(0, "$".str_replace('.',',',$datos_movieminto[1])." PESOS", '', 0, false, 'J', true, 0, false, false, 0);
$pdf->SetXY(30, 250);
$pdf->Write(0, "$".str_replace('.',',',$datos_movieminto[1]), '', 0, false, 'J', true, 0, false, false, 0);

/*
switch ($datos_movieminto[4]) {
    case 2:
        $pos = 206;
        break;
    case 3:
        $pos = 222;
        break;
    default :
        $pos = 214;
        ;
        break;
}
*/    

$pdf->SetXY(4, 206);
$pdf->Write(0, "Forma de pago:", '', 0, false, 'J', true, 0, false, false, 0);
$pdf->SetXY(4, 222);
$pdf->Write(0, $forma_de_pago, '', 0, false, 'J', true, 0, false, false, 0);

//$pdf->SetFont('zapfdingbats', '', 20);
$pdf->Write(0, '3', '', 0, false, 'J', true, 0, false, false, 0);

ob_end_clean();
//$pdf->Output(); 
if ($apertura === 'pre') {
    $pdf->Output();
} else {
    
    $id_movimiento = $_GET['id'];
    $to=$email;
    //$to = "welias@oroverdedigital.com.ar";
    $subject="Recibo Fundacion";
    
    $mensaje = DevuelveValor('1','descripcion','mensajes','id');
    
    $cuerpo=" 
        
Estimado/a $razon_social:<br><br>
    
Adjunto el recibo Nro: 0004-".$datos_movieminto[2]. "<br><br>

Correspondiente a ".$concepto."<br><br>
    
Por un monto de $ ".$monto_letras."<br><br>
    
    
$mensaje

Saludos cordiales!<br>



";
    
    $fileName= '0004-'.$datos_movieminto[2].'.pdf';
    $fileatt = $pdf->Output($fileName, 'S');
    include 'send_mail.php';
    
}
