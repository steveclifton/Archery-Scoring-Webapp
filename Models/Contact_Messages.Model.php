<?php

namespace Archery\Models;

use PDO;


/**
 *
 *
*/
class Contact_Messages extends Base
{
    /**
     * Sets the admin config
     */
    public function setMessage($name, $email, $message)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) 
                VALUES (NULL, '$name', '$email', '$message', '$date');";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$name, $email, $message, $date'));

        return true;
    }



}
