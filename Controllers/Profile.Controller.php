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

        $this->render('Profile', 'profile.view', $viewData);
    }

    public function updateProfile()
    {
        $profile = new User();
        $auth = new Authentication();

        $profile->updateUserProfileDetails($_POST);
        
        $userDetails = $profile->getUserByEmail($_POST['email']);
        $auth->setSession($userDetails[0]);

        $this->viewProfile();
    }

    public function requestAccessToAssociate()
    {
        print_r($_POST);
        die();
    }

}


