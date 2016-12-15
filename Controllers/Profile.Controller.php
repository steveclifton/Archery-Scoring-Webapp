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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $key => $post) {
                echo $key . " _ " . $post;
                echo "<br><br>";
            }
            die();
        }

        $user = new User();
        $viewData = $user->getUserByEmail($_SESSION['email']);


        $this->render('Profile', 'profile.view', $viewData[0]);
    }


}


