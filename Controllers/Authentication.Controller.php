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
        var_dump($_POST); die();


        $user = new User();

        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $user = new User();
            $existingAnzNum = $user->doesAnzNumberExist($data['anz_num']);

            if ($existingAnzNum) {
                $_SESSION['success'] = false;
            } else {
                $user->createAccount($data);
                $_SESSION['success'] = true;
            }
            header('location: /register');
            die();
        }

        $this->render('Register New User', 'register.view');
    }

    /**
     * Attempts to register a new user
     */
    public function registerProfile()
    {
        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = $_POST;
            $user = new User();
            $existingAnzNum = $user->doesAnzNumberExist($data['anz_num']);

            if ($existingAnzNum) {
                $_SESSION['successProfile'] = false;
            } else {

                $user->createProfile($data);
                $_SESSION['successProfile'] = true;
            }
            header('location: /register');
            die();

        }
        header('location: /register');
        die();

    }

    public function ajaxRegisterProfile()
    {
        $anz_num = trim($_POST['anz_num']);
        $email = trim(ucfirst($_POST['email']));
        $first_name = trim(ucfirst($_POST['first_name']));
        $last_name = trim(ucfirst($_POST['last_name']));
        $pref_type = strtolower($_POST['prefered_type']);
        $gender = strtoupper($_POST['gender']);
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
        $_SESSION['email'] = $data['email'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['gender'] = $data['gender'];
        $_SESSION['user_type'] = $data['user_type'];
        $_SESSION['prefered_type'] = $data['prefered_type'];
    }
    
}


