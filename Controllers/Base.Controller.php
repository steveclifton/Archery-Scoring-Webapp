<?php

namespace Archery\Controllers;


/**
 * Class Base
 *
 * Abstract class which provides several key functions to derrived classes
 *
 * @package
 */
abstract class Base
{
    /**
     * Redirects unauthorised access to some Views back to the account view
     *
     * eg - A logged in user does not need to see the login page.
     */
    public function isLoggedIn()
    {
        if (isset($_SESSION['id'])) {
            header('location: /myscores');
            die();
        } else {
            header('location: /');
            die();
        }
    }

    /**
     * Ensures that the user is an admin
     *
     */
    public function isAdminLoggedIn()
    {
        if (isset($_SESSION['id'])) {
            if ($_SESSION['user_type'] != 'admin') {
                header('location: /');
                die();
            }

        } else {
            header('location: /');
            die();
        }
    }

    /**
     * Redirects unauthorised access to 'logged in' Views back to the login page
     *
     */
    public function isNotLoggedIn()
    {
        if (!isset($_SESSION['id'])) {
            header('location: /');
            die();
        }
    }


    /**
     * Returns True if the user is logged in
     *
     */
    public function activeUser()
    {
        if (isset($_SESSION['id'])) {
            return true;
            die();
        }
        return false;
    }



    /**
     *  This method directs controller data to the base view
     *
     * @param $title - The title of the web page loaded
     * @param $name - name of the view to be loaded
     * @param array $data - any data required by the view
     */
    public function render($title, $name, $data = array())
    {

        $pageTitle = $title;

        $viewName = $name;

        $viewData = $data;

        include ('Views/base.view.php');
    }

}

