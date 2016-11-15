<?php

namespace Archery\Models;

use Archery\Exceptions\CustomException;


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

        $query = $this->database->query("SELECT *
                                         FROM 
                                         `users` 
                                         WHERE 
                                         email='$email'
                                         LIMIT 1
                                         "
        );

        $data = $query->fetch_assoc();

        return $data;
    }

    /**
     * Creates a new user if registration information is valid
     *
     * @param $userData
     * @return User - returns a new user object - used to log the user in automatically
     */
    public function create($userData)
    {

        /* Sanitizes and filters data before being inserted */
        $data['email'] = $this->database->real_escape_string($userData['email']);
        $data['first_name'] = ucfirst($this->database->real_escape_string($userData['first_name']));
        $data['last_name'] = ucfirst($this->database->real_escape_string($userData['last_name']));
        $data['password'] = $this->database->real_escape_string($userData['password']);
        $data['email'] = strtolower($this->database->real_escape_string($userData['email']));

        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->database->query("INSERT INTO `users` (
                                            `id`,
                                            `student_id`,
                                            `first_name`,
                                            `last_name`,
                                            `password`,
                                            `email`,
                                            `create_date`
                                            ) VALUES (
                                            NULL,
                                             '".$data['student_id']."',
                                             '".$data['first_name']."', 
                                             '".$data['last_name']."', 
                                             '".$password."',
                                             '".$data['email']."',
                                             CURRENT_TIMESTAMP
                                             )"
        );

        $newUserData = $this->getUserByEmail($data['student_id']);

        $newUser = new User();

        foreach ($newUserData as $key => $value) {
            $newUser->$key = $value;
        }

        return $newUser;
    }

    /**
     * Verifies whether the users student id and password exist and match
     *
     * @param $userData
     * @return mixed
     */
    public function verify($userData)
    {
        $data['email'] = strtolower($this->database->real_escape_string($userData['email']));
        $data['password'] = $this->database->real_escape_string($userData['password']);

        $existingUser = $this->getUserByEmail($data['email']);

        /* Checks the database to see whether passwords match, if they do, user details are returned */
        if (password_verify($data['password'], $existingUser['password'])) {
            return $existingUser;
        }
    }





}
