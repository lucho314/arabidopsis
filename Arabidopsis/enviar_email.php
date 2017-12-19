<?php
try {

    $para      = 'info@impulsodeunanuevavida.org, '.$email;

// título
$título = $subject;

// mensaje
$mensaje = $body;

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: Fundación Impulso de una nueva vida <info@impulsodeunanuevavida.org>' . "\r\n";


// Enviarlo
mail($para, $título, $mensaje, $cabeceras);
echo 'email enviado';
  
} catch (Exception $e) {
  print_r($e);
  
}


?>