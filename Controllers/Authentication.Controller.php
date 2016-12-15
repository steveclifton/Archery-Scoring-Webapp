<?php

namespace Archery\Controllers;

use Archery\Models\TempUser;
use Exception;
use Archery\Models\User;


class Authentication extends Base
{
    /**
     * Checks the users login credentials
     * - If authorised, redirect to account view
     */
    public function login()
    {
        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;

            $user = new User();
            $existingUser = $user->verify($data);

            if (isset($existingUser)) {
                $this->setSession($existingUser);
                header('location: /welcome');
                die();
            } else {
                header('location: /login');
                die();
            }
        }

        $this->render('Login Page', 'login.view');
    }

    /**
     * Destroys the SESSION and redirects to the login view
     */
    public function logout()
    {
        session_destroy();
        header('location: /login');
    }

    /**
     * Attempts to register a new user
     */
    public function register()
    {
        $user = new User();

        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $user = new User();
            try {
                $existingAnzNum = $user->doesAnzNumberExist($data['anz_num']);
                if ($existingAnzNum) {
                    $viewData['success'] = false;
                } else {
                    $user->create($data);
                    $viewData['success'] = true;
                }
                $this->render('Register New User', 'register.view', $viewData);
                die();
            } catch (Exception $e) {
                header('location: /register');
            }
        }

        $this->render('Register New User', 'register.view');
    }

    /**
     * Sets the SESSION data
     */
    public function setSession($data)
    {
        $_SESSION['id'] = $data['id'];
        $_SESSION['anz_num'] = $data['anz_num'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['gender'] = $data['gender'];
        $_SESSION['user_type'] = $data['user_type'];
        $_SESSION['prefered_type'] = $data['prefered_type'];
    }
    
}


