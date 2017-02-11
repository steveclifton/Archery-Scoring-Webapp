<?php

namespace Archery\Controllers;

use Archery\Models\AdminConfig;
use Archery\Models\TempUser;
use Exception;
use Archery\Models\User;
use Archery\Models\Score;

class Authentication extends Base
{
    /**
     * Checks the users login credentials
     * - If authorised, redirect to account view
     */
    public function login()
    {
        $this->isLoggedIn();

        $score = new Score();
        $setup = new AdminConfig();
        $currentWeek = $setup->getCurrentWeek();
        $viewData['scores'] = $score->all_getCWScores($currentWeek);
        $viewData['current_week'] = $currentWeek;


        $this->render('Login Page', 'week.view', $viewData);
    }

    /**
     * Ajax checking of the users account
     */
    public function ajaxCheckLogin()
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            echo json_encode(array("status" => "failed", "message" => "Check details and try again!"));
            die();
        }
        $existingUser = $this->verifyUser($_POST['email'], $_POST['password']);

        if (isset($existingUser)) {
            $this->setSession($existingUser);
            $viewData['first_name'] = $_SESSION['first_name'];
            $viewData['last_name'] = $_SESSION['last_name'];

            $admin = new AdminConfig();
            $week = $admin->getCurrentWeek();

            echo json_encode(array("status" => "success", "message" => "valid user", "week" => $week));
            die();

        } else {
            echo json_encode(array("status" => "failed", "message" => "Check account details and try again!"));
            die();
        }
    }

    /**
     * Used to verify the users login details
     */
    private function verifyUser($email, $password)
    {
        $user = new User();
        $existingUser = $user->getUserByEmail(strtolower($email));

        if (isset($existingUser['0'])) {
            $existingUser = $existingUser['0'];
            if (password_verify($password, $existingUser['password'])) {
                return $existingUser;
            }
        } else {
            return false;
        }



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
        $this->render('Register New User', 'register.view');
    }

    /**
     * Method used by AJAX to register an ACCOUNT
     */
    public function ajaxRegisterAccount()
    {
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);

        if ($password != $confirmPassword) {
            echo json_encode(array("status" => "failed", "message" => "passwords do not match"));
            return;
        }

        $user = new User();
        $existingAnzNum = $user->doesAnzNumberExist($_POST['anz_num']);

        if (!$existingAnzNum) {
            $result = $user->createAccount($_POST);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Account Created"));
                return;
            } else {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            }
        } else {
            echo json_encode(array("status" => "failed", "message" => "ANZ Number already exists"));
            return;
        }


    }

    /**
     * Method used by AJAX to register a PROFILE
     */
    public function ajaxRegisterProfile()
    {
        $user = new User();
        $existingAnzNum = $user->doesAnzNumberExist($_POST['anz_num']);

        if (!$existingAnzNum) {
            $result = $user->createProfile($_POST);
            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Account Created"));
                return;
            } else {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            }
        } else {
            echo json_encode(array("status" => "failed", "message" => "ANZ Number already exists"));
            return;
        }


    }


    /**
     * Sets the SESSION data
     */
    public function setSession($data)
    {
        $_SESSION['id'] = $data['id'];
        $_SESSION['anz_num'] = $data['anz_num'];
        $_SESSION['email'] = ucwords($data['email']);
        $_SESSION['first_name'] = ucfirst($data['first_name']);
        $_SESSION['last_name'] = ucfirst($data['last_name']);
        $_SESSION['gender'] = ucfirst($data['gender']);
        $_SESSION['user_type'] = $data['user_type'];
        $_SESSION['prefered_type'] = $data['prefered_type'];

        $setup = new AdminConfig();
        $_SESSION['current_week'] = $setup->getCurrentWeek();

    }
    
}


