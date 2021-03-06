<?php

namespace Archery\Controllers;

use Archery\Models\User;

class Profile extends Base
{
    /**
     * Checks the users login credentials
     * - If authorised, redirect to account view
     */
    public function viewProfile()
    {
        $this->isNotLoggedIn();

        $user = new User();
        $details = $user->getUserByEmail($_SESSION['email']);
        $viewData['user'] = $details[0];

        $associatedUsers = $this->getAssociatedUsers();

        $viewData['access_users'] = $associatedUsers;

        $this->render('Profile', 'profile.view', $viewData);
    }


    /**
     * Receives info from the profile update page (from Ajax)
     */
    public function ajaxUpdateProfile()
    {

        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);

        if ($password != $confirmPassword) {
            echo json_encode(array("status" => "failed", "message" => "passwords do not match"));
            return;
        }

        $user = new User();
        $result = $user->updateUserProfileDetails($_POST);


        if ($result) {
            echo json_encode(array("status" => "success", "message" => "Profile Updated"));
            return;
        } else {
            echo json_encode(array("status" => "failed", "message" => "Please check details and try again"));
            return;
        }
    }


    /**
     * Updates an association between users
     */
    public function updateAssociation()
    {
        $user = new User();
        $requestAnz = $user->getUserIdByAnzNum($_POST['anz_num']);

        if ($_POST['submit'] == 'Request Access') {
            //user is requesting access here
            $result = $user->checkAssociation($_SESSION['id'], $requestAnz);
            if (!isset($result[0])) {
                $result = $user->setAssociatedUser($_SESSION['id'], $requestAnz, 'CONFIRMED');
            }
        } else if ($_POST['submit'] == 'Remove') {
            $result = $user->removeAssociation($_SESSION['id'], $requestAnz);
        }
        header('location: /userprofile');
        die();
    }


    private function getAssociatedUsers()
    {
        $user = new User();

        $associatedUsers = $user->getAssociatedUsers($_SESSION['id']);

        return $associatedUsers;
    }

}


