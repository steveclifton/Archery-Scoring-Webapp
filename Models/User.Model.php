<?php

namespace Archery\Models;

use Archery\Exceptions\CustomException;

use PDO;


/**
 * Class User
 *
 * Class used to query the database for user data
 *
 * @package
 */
class User extends Base
{

    public function getUserByEmail($email)
    {
        $sql = "SELECT * 
                FROM `users` 
                WHERE email='$email' 
                LIMIT 1 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$email'));

        $data = $stm->fetchAll();

        return $data;
    }

    /**
     * Creates a new user if registration information is valid

     * - returns a new user object - used to log the user in automatically
     */
    public function create($userData)
    {
        $email = ucfirst($userData['email']);
        $firstName = ucfirst($userData['first_name']);
        $lastName = ucfirst($userData['last_name']);
        $anzNum = $userData['anz_num'];
        $club = ucfirst($userData['club']);
        $preferedType = $userData['prefered_type'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $password = password_hash($userData['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `temp_user` (`id`, `email`, `anz_num`, `first_name`, `last_name`, `club`, `prefered_type`, `password`, `ip_address`, `created_at`) 
                VALUES (NULL, '$email', '$anzNum', '$firstName', '$lastName', '$club', '$preferedType', '$password', '$ipAddress', CURRENT_TIMESTAMP);";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$email, $anzNum, $firstName, $lastName, $club, $password, $ipAddress'));

        return $success;

    }

    /**
     * Verifies whether the users student id and password exist and match
     *
     * @param $userData
     * @return mixed
     */
    public function verify($userData)
    {
        $existingUser = $this->getUserByEmail($userData['email']);

        if (isset($existingUser)) {
            $existingUser = $existingUser['0'];
        }

        /* Checks the database to see whether passwords match, if they do, user details are returned */
        if (password_verify($userData['password'], $existingUser['password'])) {
            return $existingUser;
        } else {
            $_SESSION['failedLogin'] = "*Invalid Login";
        }
    }

    public function doesAnzNumberExist($numToCheck)
    {
        $sql = "SELECT * FROM `users` WHERE anz_num = '$numToCheck' LIMIT 1 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$numToCheck'));

        $data = $stm->fetchAll();

        if (isset($data[0])) {
            return true;
        }

        return false;
    }

}
