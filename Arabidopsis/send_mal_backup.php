<?php
/*
Script que permite enviar correos con archivos adjuntos,
 * requiere que antes de incluir este script esten definidas las variables
 * $to: que es el destinatario del correo.
 * $subject: Asunto del correo.
 * $cuerpo: el cuerpo del mensaje.
 * $fileName: nombre del arhivo por ejemplo recibo.pdf.
 * $fileatt:archivo pdf creado con fpdf de la siguiente manera $pdf->Output($fileName, 'E');
 *  */


$repEmail = 'info@impulsodeunanuevavida.org';
$attachment = chunk_split($fileatt);

if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");

$eol = PHP_EOL;
$separator = md5(time());

$headers  = 'From: Fundacion <'.$repEmail.'>'.$eol;
$headers .= 'Cc: info@impulsodeunanuevavida.org' .$eol;
$headers .= 'BCc: welias@oroverdedigital.com.ar' .$eol;
$headers .= 'MIME-Version: 1.0' .$eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

$message = "--".$separator.$eol;
$message .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$message .= $cuerpo."".$eol;

$message .= "--".$separator.$eol;
$message .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$message .= "Content-Transfer-Encoding: 8bit".$eol.$eol;

$message .= "--".$separator.$eol;
$message .= "Content-Type: application/pdf; name=\"".$fileName."\"".$eol; 
$message .= "Content-Transfer-Encoding: base64".$eol;
$message .= "Content-Disposition: attachment".$eol.$eol;
$message .= $attachment.$eol;
$message .= "--".$separator."--";


$atras='menu_principal.php';
if (mail($to, $subject, $message, $headers)){
    if($fileName=== '0004-'.$datos_movieminto[2].'.pdf')
    {
       $descripcion='RECIBO NRO: 0004-'.$datos_movieminto[2];
       $sql_maquina="INSERT INTO `registro_de_estados` "
               . "("
               . "`id`, "
               . "`descripcion`, "
               . "`tabla`, "
               . "`registro_id`, "
               . "`fecha_cambio_estado`, "
               . "`estado_id`, `usuario_id`, "
               . "`empresa_id`"
               . ") VALUES ("
               . "NULL, "
               . "'$descripcion', "
               . "'movimientos', "
               . "'". $_GET['id']."', "
               . "CURDATE(), "
               . "9, "
               . "'1', "
               . "'1'"
               . ");";

          mysql_query($sql_maquina);//actualizo la maquina de estado con el recibo generado 
    }
$texto= "Email enviado a: ";
$arrat_to=explode(",", $to);
foreach ($arrat_to as $value) {
    $texto.= $value.";";
    
}

$atras.='?alerta='.$texto;
header('Location: '.$atras);
}

else {
$atras.='?alerta=error al enviar el mail';
header('Location: '.$atras);
}

?>
