<?php

namespace Archery\Models;

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

    /**
     * Returns a users details by email
     */
    public function getUserByEmail($email)
    {
        $email = strtolower($email);

        $sql = "SELECT * 
                FROM `users` 
                WHERE email LIKE '$email' 
                LIMIT 1 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$email'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Updates the users profile details
     */
    public function updateUserProfileDetails($userData)
    {
        $id = $_SESSION['id'];
        $email = strtolower($userData['email']);
        $firstName = strtolower($userData['first_name']);
        $lastName = strtolower($userData['last_name']);
        $club = strtolower($userData['club']);
        $phone = $userData['phone'];
        $address = $userData['address'];
        $preferedType = $userData['prefered_type'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        if ($userData['password'] != null){
            $password = password_hash($userData['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE `users` 
                  SET 
                  `first_name` = '$firstName',
                  `last_name` = '$lastName',
                  `email` = '$email',
                  `password` = '$password',
                  `club` = '$club', 
                  `phone` = '$phone',
                  `address` = '$address',
                  `prefered_type` = '$preferedType',
                  `last_ip` = '$ipAddress',
                  `updated_at` = CURRENT_TIMESTAMP 
                WHERE `users`.`id` = '$id'";
        } else {
            $sql = "UPDATE `users` 
                  SET 
                  `first_name` = '$firstName',
                  `last_name` = '$lastName',
                  `email` = '$email',
                  `club` = '$club', 
                  `phone` = '$phone',
                  `address` = '$address',
                  `prefered_type` = '$preferedType',
                  `last_ip` = '$ipAddress',
                  `updated_at` = CURRENT_TIMESTAMP 
                WHERE `users`.`id` = '$id'";
        }

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$firstName, $lastName, $email, $password, $club, $phone, $address, $preferedType, $ipAddress, $id'));

        return $success;
    }

    /**
     * Creates an account if registration information is valid
     * - returns a new user object - used to log the user in automatically
     */
    public function createAccount($anz, $fName, $lName, $emailAddress, $type, $pass)
    {
        $anzNum = trim($anz);
        $firstName = strtolower(trim($fName));
        $lastName = strtolower(trim($lName));
        $gender = "NULL";
        $club = "NULL";
        $email = strtolower(trim($emailAddress));
        $preferedType = strtolower(trim($type));
        $userType = 'pending';

        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` 
                  (`id`, `anz_num`, `first_name`, `last_name`, `gender`, `club`, `phone`, `address`, `user_type`, `email`, `password`, `prefered_type`, `last_ip`, `created_at`) 
                VALUES 
                  (NULL, '$anzNum', '$firstName', '$lastName', '$gender', '$club', NULL, NULL, '$userType', '$email', '$password', '$preferedType', '$ipAddress', CURRENT_TIMESTAMP)";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$anzNum, $firstName, $lastName, $gender, $userType, $email, $password, $preferedType, $ipAddress'));

        $userId = $this->getUserIdByAnzNum($anzNum);

        $this->setAssociatedUser($userId, $userId, "PENDING");

        return $success;
    }


    /**
     * Creates a profile if registration information is valid
     * - returns a new user object - used to log the user in automatically
     */
    public function createProfile($anz, $fName, $lName, $emailAddress, $pType)
    {
        $anzNum = trim($anz);
        $firstName = strtolower(trim($fName));
        $lastName = strtolower(trim($lName));
        $gender = 'NULL';
        $email = strtolower(trim($emailAddress));
        $preferedType = strtolower(trim($pType));
        $userType = 'pending';

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $sql = "INSERT INTO `users` 
                  (`id`, `anz_num`, `first_name`, `last_name`, `gender`, `club`, `phone`, `address`, `user_type`, `email`, `password`, `prefered_type`, `last_ip`, `created_at`) 
                VALUES 
                  (NULL, '$anzNum', '$firstName', '$lastName', '$gender', NULL, NULL, NULL, '$userType', '$email', NULL, '$preferedType', '$ipAddress', CURRENT_TIMESTAMP)";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$anzNum, $firstName, $lastName, $gender, $userType, $email, $password, $preferedType, $ipAddress'));

        $userId = $this->getUserIdByAnzNum($anzNum);

        $this->setAssociatedUser($userId, $userId, "PENDING");

        return $success;
    }

    /**
     * Returns a list of users that a pending approval
     */
    public function getPendingUsers()
    {
        $sql = "SELECT *
                FROM `users` 
                WHERE `user_type` = 'pending'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }


    /**
     * Returns a ID number for a anz_num
     */
    public function getUserIdByAnzNum($anzNum)
    {
        $sql = "SELECT users.id 
                FROM `users` 
                WHERE `anz_num`='$anzNum'
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        if (isset($data[0]['id'])) {
            return $data[0]['id'];
        } else {
            return false;
        }

    }


    /**
     * Updates a users type from Pending to be 'user'
     *  - This is controlled from the admin view
     *  - Creates an association between the user and themself
     */
    public function confirmPendingUsers($userData)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $userId = $userData['id'];
        $firstName = strtolower($userData['first_name']);
        $lastName = strtolower($userData['last_name']);
        $anzNum = $userData['anz_num'];
        $userType = 'user';
        $email = strtolower($userData['email']);

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $sql = "UPDATE `users` 
                SET 
                  `anz_num` = '$anzNum', 
                  `first_name` = '$firstName',
                  `last_name` = '$lastName',
                  `user_type` = '$userType',
                  `last_ip` = '$ipAddress',
                  `updated_at` = '$date'
                WHERE `users`.`id` = '$userId'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $success = $stm->execute(array('$anzNum, $firstName, $lastName, $club, $userType, $ipAddress, $email, $date'));

        $this->updateAssociation($userData['id'], "CONFIRMED");

        return $success;
    }

    /*
     * Updates a users association in the Join Table
     */
    private function updateAssociation($userId, $status)
    {
        $sql = "UPDATE `join_users` 
                SET `status` = '$status' 
                WHERE `join_users`.`user_id` = '$userId';
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $assocUser, $status'));

        return;
    }

    /**
     * Creates an association between users
     */
    public function setAssociatedUser($userId, $assocUser, $status)
    {

        $sql = "INSERT INTO `join_users` (`id`, `user_id`, `associate_id`, `status`) 
                VALUES (NULL, '$userId', '$assocUser', '$status');";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $assocUser, $status'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Check whether an association exists or not
     */
    public function checkAssociation($userId, $assocUser)
    {
        $sql = "SELECT * 
                FROM `join_users` 
                WHERE user_id = '$userId' 
                AND associate_id = '$assocUser'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $assocUser'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Remove association
     */
    public function removeAssociation($userId, $assocUser)
    {
        $sql = "DELETE FROM `join_users` 
                WHERE `join_users`.`user_id` = '$userId'
                AND `join_users`.`associate_id` = '$assocUser'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $assocUser'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;


    }

    /**
     * Returns all users that the logged in user has an association with
     */
    public function getAssociatedUsers($userId)
    {
        $sql = "SELECT users.first_name, users.last_name, users.anz_num, users.club, users.email, join_users.status 
                FROM `join_users` 
                INNER JOIN users 
                ON `join_users`.associate_id = users.id 
                WHERE `join_users`.user_id = '$userId'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Gets all associated users for scoring
     *  - (includes self)
     */
    public function getAllUsersForScoring()
    {
        $userId = $_SESSION['id'];


        $sql = "SELECT users.first_name, users.prefered_type, users.last_name, users.anz_num, users.club, users.email, join_users.status 
                FROM `join_users` 
                INNER JOIN users 
                ON `join_users`.associate_id = users.id 
                WHERE `join_users`.user_id = '$userId'
                AND (`join_users`.status = 'CONFIRMED' OR `join_users`.status = 'TEMP')
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Check to see whether the ANZ number exists in the database or not
     */
    public function doesAnzNumberExist($numToCheck)
    {
        $sql = "SELECT * 
                FROM `users` 
                WHERE anz_num = '$numToCheck' 
                LIMIT 1 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$numToCheck'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0])) {
            return true;
        }

        return false;
    }

}
