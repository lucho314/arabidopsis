<?php

/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

 $body = '

$subject = "Email de prueba desde smtp gmail";
$repEmail = 'info@impulsodeunanuevavida.org';
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
             $mail->SMTPDebug = 2;                        // TCP port to connect to
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'luciano.zapata314@gmail.com';                 // SMTP username
    $mail->Password = 'lucianokito314';                           // SMTP password
    $mail->SMTPSecure = 'tls';       

    //Recipients
    $mail->From = $repEmail;
    $mail->FromName = $repEmail;
    $mail->addAddress('luciano.zapata314@outlook.com', 'Joe User');  

    //Recipients
//    $mail->From = "luciano.zapata314@gmail.com";
  //  $mail->FromName = "Fundacion impulso de una nueva vida";
    $mail->addAddress('luciano.zapata314@gmail.com');  
 //   $mail->addAddress('luciano.zapata314@outlook.com');  
    $mail->addAddress('luciano.zapata314@yahoo.com');  
    $mail->addAddress('info@lucez.biz');  
    $mail->addAddress('cv@lucez.biz');  
    //$mail->addAddress($email);  

     $mail->isHTML(true);
     $mail->CharSet = 'UTF-8';                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    //$mail->CharSet = 'UTF-8';

    $mail->send();*/



try {

    $para      = 'luciano.zapata314@gmail.com, luciano.zapata314@yahoo.com, luciano.zapata314@outlook.com, info@lucez.biz, cv@lucez.biz';

// título
$título = 'Prueba de recepción de correo';

// mensaje
$mensaje = '<html>
     <head>
        <title>Email de prueba desde smtp gmail</title>
     </head>
     <body>
       <p>Email de prueba</p>
       <p>Este email es solo con fines de probar la recepción de correos electronicos.</p>
       <p>Por favor avisar a luciano.zapata314@gmail.com si recibió este correo.</p>
       <br>
       <p><b>Saludos luciano zapata</b></p>
       <p>
     </body>
    </html>';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'From: Impulso de una nueva vida <info@impulsodeunanuevavida.org>' . "\r\n";


// Enviarlo
mail($para, $título, $mensaje, $cabeceras);
echo 'email enviado';
  
} catch (Exception $e) {
  print_r($e);
  
}

?>