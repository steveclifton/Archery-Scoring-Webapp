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

        // Updates the users details in the
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $profile = new User();
            $auth = new Authentication();

            $result = $profile->updateUserProfileDetails($_POST);
            $viewData['success'] = $result;

            $userDetails = $profile->getUserByEmail($_POST['email']);
            $auth->setSession($userDetails[0]);
        }

        $user = new User();
        $details = $user->getUserByEmail($_SESSION['email']);
        $viewData['user'] = $details[0];

        $this->render('Profile', 'profile.view', $viewData);
    }


}


