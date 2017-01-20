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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            $existingUser = $user->verify($_POST);

            if (isset($existingUser)) {
                $this->setSession($existingUser);
                $viewData['first_name'] = $_SESSION['first_name'];
                $viewData['last_name'] = $_SESSION['last_name'];

                $scores = new Score();
                $scores = $scores->liu_getAllScores();
                $viewData['scores'] = $scores;

                header('location: /welcome');
                die();

            } else {
                header('location: /login');
                die();
            }
        } else {
            $score = new Score();
            $setup = new AdminConfig();
            $currentWeek = $setup->getCurrentWeek();
            $viewData['scores'] = $score->all_getCWScores($currentWeek);
            $viewData['current_week'] = $currentWeek;
        }

        $this->render('Login Page', 'week.view', $viewData);
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
        $anz_num = trim(strtolower(['anz_num']));
        $club = trim(strtolower($_POST['club']));
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);
        $email = trim(strtolower($_POST['email']));
        $first_name = trim(strtolower($_POST['first_name']));
        $last_name = trim(strtolower($_POST['last_name']));
        $pref_type = strtolower($_POST['prefered_type']);
        $gender = strtolower($_POST['gender']);
        $userType = 'user';

        if ($password != $confirmPassword) {
            echo json_encode(array("status" => "failed", "message" => "passwords do not match"));
            return;
        }

        $user = new User();
        $existingAnzNum = $user->doesAnzNumberExist($anz_num);

        if (!$existingAnzNum) {
            $result = $user->createAccount($anz_num, $first_name, $last_name, $gender, $club, $userType, $email, $password, $pref_type);
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
        $anz_num = trim($_POST['anz_num']);
        $email = trim(strtolower($_POST['email']));
        $first_name = trim(strtolower($_POST['first_name']));
        $last_name = trim(strtolower($_POST['last_name']));
        $pref_type = strtolower($_POST['prefered_type']);
        $gender = strtolower($_POST['gender']);
        $userType = 'user';

        $user = new User();
        $existingAnzNum = $user->doesAnzNumberExist($anz_num);

        if (!$existingAnzNum) {
            $result = $user->createProfile($anz_num, $first_name, $last_name, $gender, $userType, $email, $pref_type);
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
        $_SESSION['first_name'] = ucfirst(['first_name']);
        $_SESSION['last_name'] = ucfirst(['last_name']);
        $_SESSION['gender'] = ucfirst(['gender']);
        $_SESSION['user_type'] = $data['user_type'];
        $_SESSION['prefered_type'] = $data['prefered_type'];
    }
    
}


