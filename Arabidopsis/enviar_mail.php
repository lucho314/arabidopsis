
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

class mail {

    private $mailer;

    function __construct() {
    $this->mailer = new PHPMailer;
    $repEmail = 'info@impulsodeunanuevavida.org';                             // Passing `true` enables exceptions
                                 // TCP port to connect to

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
    //$this->SMTPDebug = 2;                                 // Enable verbose debug output
   /* $this->isSMTP();                                      // Set mailer to use SMTP
    $this->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $this->SMTPAuth = true;                               // Enable SMTP authentication
    $this->Username = 'luciano.zapata314@gmail.com';                 // SMTP username
    $this->Password = 'lucianokito314';                           // SMTP password
    $this->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $this->Port = 587;*/
    $this->mailer->From = 'info@impulsodeunanuevavida.org';
    $this->mailer->addAddress('luciano.zapata314@outlook.com', 'Luciano zapata outlook');

        return $this;
    }

    function addHtml($html){

      $this->mailer->isHTML(true);                                  // Set email format to HTML
      $this->mailer->Body = $html;
      return $this;
    }

    function addAddress($addres,$nombre=''){
        $this->mailer->addAddress($ad);
    }

    function enviar(){
       return $this->Send();
    }

    function mail_adjunto($subjet, $to, $cuerpo, $adjunto) {
        $this->mailer->SetFrom('welias@hotmail.com.ar', 'Sent From');
        $this->mailer->AddAddress($to, 'Send To');
        $this->mailer->Subject = $subjet;
        $this->mailer->MsgHTML($cuerpo);
        $this->mailer->AddStringAttachment($adjunto, 'recibo.pdf');
        $this->mailer->Send();
    }

}
