<?php

namespace Archery\Controllers;

class Mail extends Base
{
    private $mail;

    /**
     */
    public function __construct()
    {
        $this->mail = new \PHPMailer();
    }

    public function sendEmail($email)
    {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('GMAIL_EMAIL');
        $this->mail->Password = getenv('GMAIL_PASS');
        $this->mail->setFrom('anzindoor@gmail.com', 'Archery NZ League Series');

        $this->mail->addAddress($email);
        $this->mail->addCC('anzindoor@gmail.com');
        $this->mail->Subject = 'League Series Enquiry';

        $this->mail->Body = "Thank you for your enquiry, someone will be in touch shortly";

        if (!$this->mail->send()) {
            return false;
        } else {
            return true;
        }

    }


}
