<?php


namespace Archery\Controllers;


use Archery\Models\AdminConfig;
use Archery\Models\Score;

class Welcome extends Base
{

    /**
     * Checks the users login credentials
     * - If authorised, redirect to account view
     */
    public function welcome()
    {
        $this->render('Welcome', 'home.view');
    }

    /**
     * Gets the users details from SESSION and passes to the view
     */
    public function processWelcome()
    {
        $this->isNotLoggedIn();

        $viewData['first_name'] = $_SESSION['first_name'];
        $viewData['last_name'] = $_SESSION['last_name'];

        $scores = new Score();
        $scores = $scores->liu_getAllScores();
        $viewData['scores'] = $scores;

        $this->render('Welcome', 'myscores.view', $viewData);
    }


    public function displayRules()
    {
        $this->render('Rules', 'rules.view');
    }



}

