<?php

namespace Archery\Controllers;

use Archery\Models\AdminConfig;
use Archery\Models\Contact_Messages;
use Archery\Models\User;

class Contact extends Base
{
    /**
     * Routes to the contact view
     */
    public function contact()
    {
        $this->render('Contact', 'contact.view');
    }

    /**
     * ajax method to set message in DB
     *
     * Todo - add phpmailer
     */
    public function ajax_contactForm()
    {
        $name = strtolower(trim($_POST['name']));
        $email = strtolower(trim($_POST['email']));
        $message = strtolower(trim($_POST['message']));

        $contact = new Contact_Messages();
        $result = $contact->setMessage($name, $email, $message);

        if ($result) {
            echo json_encode(array('status' => 'passed', 'message' => 'Message Sent'));
            $mail = new Mail();
            $mail->sendEmail($email);
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Please try again later'));
        }
        return;
    }

}
