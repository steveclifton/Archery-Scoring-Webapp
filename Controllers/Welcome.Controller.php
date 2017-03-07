<?php


namespace Archery\Controllers;


use Archery\Models\AdminConfig;
use Archery\Models\Score;

class Welcome extends Base
{

//    /**
//     * Checks the users login credentials
//     * - If authorised, redirect to account view
//     */
//    public function welcome()
//    {
//
//        $score = new Score();
//        $setup = new AdminConfig();
//        $currentWeek = $setup->getCurrentWeek();
//
//        $viewData['scores'] = $score->all_getCWScores($currentWeek);
//        $viewData['current_week'] = $currentWeek;
//
//        $this->render('Welcome', 'home.view', $viewData);
//    }

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

