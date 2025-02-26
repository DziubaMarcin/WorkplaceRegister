<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  function send_activation_mail($emailadderss, $activationcode) {

    //Load Composer's autoloader
    //require 'vendor/autoload.php';
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Strin settings
        $mail->Encoding = 'base64';
        $mail->CharSet = 'UTF-8';
        //Server settings
        $mail->SMTPDebug = 1;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'example@gmail.com';                     //SMTP username
        $mail->Password   = 'password';                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('001.test.konto.999@gmail.com', 'XYZ Sp. z o.o.');
        $mail->addAddress("$emailadderss");     //Add a recipient

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Weryfikacja Konta Panelu Użytkownika XYZ Sp. z o.o.';
        $mail->Body    = "
        Witaj!
        Aby potwierdzić swoją tożsamość i zwiększyć szansę na aktywacje twojego konta przez Administratora,
        Kliknij na poniższy link aby zweryfikować podany adres e-mail
        <br>
        <hr>
        <a href=\"http://localhost/Projekt/Gotowy%20Projekt%202%20-%20weryfikacja%20email/verify.php?email=$emailadderss&activation_code=$activationcode\" target=\"_blank\">Link Aktywacyjny</a>
        <hr>
        <br>
        <b>Jeżeli uważasz, że ta wiadomość nie jest do Ciebie skierowana - zignoruj ją!</b>
        ";
        $mail->AltBody = "
        Witaj!
        Aby potwierdzić swoją tożsamość i zwiększyć szansę na aktywacje Twojego konta przez Administratora,
        Kliknij na poniższy link aby zweryfikować podany adres e-mail

        http://localhost/Projekt/Gotowy%20Projekt%202%20-%20weryfikacja%20email/verify.php?email=$emailadderss&activation_code=$activationcode/

        Jeżeli uważasz, że ta wiadomość nie jest do Ciebie skierowana - zignoruj ją!
        ";

        $mail->send();
    } catch (Exception $e) {
      header("location: ./unexpected-error.php");
      exit();
    }
  }
?>
