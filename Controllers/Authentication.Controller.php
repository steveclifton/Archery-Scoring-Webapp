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
            // TODO
            $week = $admin->getCurrentWeek(3);

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
        header('location: /');
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
        if (isset($_POST['anz_num'])) {
            if ($_POST['anz_num'] == '') {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $anzNum = $_POST['anz_num'];
            }
        }
        if (isset($_POST['email'])) {
            if ($_POST['email'] == '') {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $email = $_POST['email'];
            }
        }
        if (isset($_POST['first_name'])) {
            if ($_POST['first_name'] == '' ) {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $firstName = $_POST['first_name'];
            }
        }
        if (isset($_POST['last_name'])) {
            if ($_POST['last_name'] == '' ) {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $lastName = $_POST['last_name'];
            }
        }
        if (isset($_POST['prefered_type'])) {
            if ($_POST['prefered_type'] == '' ) {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $type = $_POST['prefered_type'];
            }
        }



        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);

        if ($password != $confirmPassword) {
            echo json_encode(array("status" => "failed", "message" => "passwords do not match"));
            return;
        }



        $user = new User();
        $existingAnzNum = $user->doesAnzNumberExist($anzNum);

        if (!$existingAnzNum) {
            $result = $user->createAccount($anzNum, $firstName, $lastName, $email, $type, $password);
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
        if (isset($_POST['anz_num'])) {
            if ($_POST['anz_num'] == '') {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $anzNum = $_POST['anz_num'];
            }
        }
        if (isset($_POST['email'])) {
            if ($_POST['email'] == '') {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $email = $_POST['email'];
            }
        }
        if (isset($_POST['first_name'])) {
            if ($_POST['first_name'] == '' ) {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $firstName = $_POST['first_name'];
            }
        }
        if (isset($_POST['last_name'])) {
            if ($_POST['last_name'] == '' ) {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $lastName = $_POST['last_name'];
            }
        }
//        if (isset($_POST['gender'])) {
//            if ($_POST['gender'] == '' ) {
//                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
//                return;
//            } else {
//                $gender = $_POST['gender'];
//            }
//        }
        if (isset($_POST['prefered_type'])) {
            if ($_POST['prefered_type'] == '' ) {
                echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
                return;
            } else {
                $type = $_POST['prefered_type'];
            }
        }


        $user = new User();
        $existingAnzNum = $user->doesAnzNumberExist($anzNum);



        if (!$existingAnzNum) {
            $result = $user->createProfile($anzNum, $firstName, $lastName, $email, $type);
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
        // TODO
        $_SESSION['current_week'] = $setup->getCurrentWeek(3);

    }
    
}


