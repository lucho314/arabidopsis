<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';
$repEmail = 'info@impulsodeunanuevavida.org';
$attachment = chunk_split($fileatt);
$atras='menu_principal.php';
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                 // TCP port to connect to
 $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'luciano.zapata314@gmail.com';                 // SMTP username
    $mail->Password = 'lucianokito314';                           // SMTP password
    $mail->SMTPSecure = 'tls';       

    //Recipients
    $mail->From = $repEmail;
    $mail->FromName = $repEmail;
    $mail->addAddress('luciano.zapata314@outlook.com', 'Joe User');     // Add a recipient

    if (!empty($to) && !eregi(',', $to)) {
  $mail->AddAddress($to); 
}elseif(!empty($to) && eregi(',', $to)) {
  $tmp_to = explode(",", $to);
  foreach ($tmp_to as $_tmp_to) {
    $mail->AddAddress($_tmp_to); 
  }
}


if(isset($fileatt)){
    $mail->AddStringAttachment($fileatt, $fileName, 'base64', 'application/pdf');
    }

   // $mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
  /// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('C:\xampp\htdocs\mail\recibos generados\0004-1160.pdf');    // Optional name

    //Content
    
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $cuerpo;


   if ($mail->Send()){
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
                 . "`estado_id`, "
                 . "`usuario_id`, "
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
            $texto= "Email enviado a: ";
      $arrat_to=explode(",", $to);
      foreach ($arrat_to as $value) {
          $texto.= $value.";";
          
      }

    $atras.='?alerta='.$texto;
    header('Location: '.$atras);
    }
      }

      
      else {
$atras.='?alerta=error al enviar el mail';
header('Location: '.$atras);
}

    


