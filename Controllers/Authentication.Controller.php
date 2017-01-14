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

                $this->render('Welcome', 'welcome.view', $viewData);
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

        $this->render('Login Page', 'login.view', $viewData);
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
                    $user->createAccount($data);
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
     * Attempts to register a new user
     */
    public function registerProfile()
    {
        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);die();

            $data = $_POST;
            $user = new User();
            $existingAnzNum = $user->doesAnzNumberExist($data['anz_num']);

            if ($existingAnzNum) {
                $viewData['successProfile'] = false;
            } else {
                $as = $user->createProfile($data);
                $viewData['successProfile'] = true;
            }
            $this->render('Register New User', 'register.view', $viewData);
            die();

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


