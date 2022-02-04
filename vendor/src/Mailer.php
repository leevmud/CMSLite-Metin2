<?php
namespace CMSLite;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use CMSLite\User;
use CMSLite\Translate;

class Mailer{

    private $mail;

    public function __construct($mailTo, $addressName, $subject, $mailBody){
        $this->mail = new PHPMailer();

        try {
            //Server settings
            $this->mail->SMTPDebug = 0;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = MAIL['HOST'];                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = MAIL['USERNAME'];                     //SMTP username
            $this->mail->Password   = MAIL['PASSWORD'];                               //SMTP password
            $this->mail->SMTPSecure = MAIL['SMTP_SECURE'];            //Enable implicit TLS encryption
            $this->mail->Port       = MAIL['PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $this->mail->setFrom(MAIL['REMETENTE'], MAIL['RE_NOME']);
            $this->mail->addAddress($mailTo, $addressName);     //Add a recipient
            $this->mail->addReplyTo(MAIL['REPLYTO'], MAIL['REPLY_NAME']);

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $mailBody;
        
            $this->mail->send();
            User::setMsg([Translate::text('sent_email'), 'success']);
            return true;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            User::setMsg(["$this->mail->ErrorInfo", 'failed']);
            return false;
        }

    }
}