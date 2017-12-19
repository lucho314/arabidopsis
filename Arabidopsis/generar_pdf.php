<?php


$iva21 = 0;
$iva105 = 0;

$dia = date('d');
$mes = date('m');
$anio = date('y');
$fecha = date('Y-m-d');

require('fpdf.php');

//Seteo los margenes

$LM = 6; //margen izquierdo
$TM = 17; //margen superior


$pdf=new FPDF;  //Genera instancia a la clase
$pdf->AddPage(); //Crea una pagina nueva
$pdf->SetFont('Times','B',12); //setea la fuente



//dia
$pdf->SetXY($LM+153,$TM+30); //ubica el cursos para imprimir el día
$pdf->Cell(10,8,$dia,0,0,'C'); //imprime el día

//mes
$pdf->SetXY($LM+165,$TM+30); //ubica el cursor para imprimir el mes
$pdf->Cell(10,8,$mes,0,0,'C'); //imprime el mes

//anio
$pdf->SetXY($LM+176,$TM+30); //ubica el cursor para imprimir el a&ntilde;o
$pdf->Cell(10,8,$anio,0,0,'C'); //imprime el a&ntilde;o



$pdf->Output();
?>