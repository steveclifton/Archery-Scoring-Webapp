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
        $anzNum = "PENDING-" . $userData['anz_num'];
        $userType = 'PENDING';
        $club = ucfirst($userData['club']);
        $preferedType = $userData['prefered_type'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $password = password_hash($userData['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`id`, `anz_num`, `first_name`, `last_name`, `gender`, `dob`, `phone`, `address`, `user_type`, `email`, `password`, `prefered_type`, `last_ip`, `created_at`) 
                VALUES (NULL, '$anzNum', '$firstName', '$lastName', NULL, NULL, NULL, NULL, '$userType', '$email', '$password', '$preferedType', '$ipAddress', CURRENT_TIMESTAMP)";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$anzNum, $firstName, $lastName, $userType, $email, $password, $preferedType, $ipAddress'));

        return $success;

    }

    public function getPendingUsers()
    {
        $sql = "SELECT * 
                FROM `users` 
                WHERE `user_type`='PENDING'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll();

        return $data;
    }

    public function confirmPendingUsers($userData)
    {
        //var_dump($userData);die();
        $email = ucfirst($userData['email']);
        $firstName = ucfirst($userData['first_name']);
        $lastName = ucfirst($userData['last_name']);
        $anzNum = $userData['anz_num'];
        $userType = 'user';
        $club = $userData['club'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $sql = "UPDATE `users` 
                SET 
                  `anz_num` = '$anzNum', 
                  `first_name` = '$firstName',
                  `last_name` = '$lastName',
                  `club` = '$club', 
                  `user_type` = '$userType',
                  `last_ip` = '$ipAddress'
                WHERE `users`.`email` = '$email'";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$anzNum, $firstName, $lastName, $club, $userType, $ipAddress, $email'));

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
        $sql = "SELECT * 
                FROM `users` 
                WHERE anz_num = '$numToCheck' 
                LIMIT 1 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$numToCheck'));

        $data = $stm->fetchAll();

        if (isset($data[0])) {
            return true;
        }

        return false;
    }

}
