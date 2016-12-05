<?php


namespace Archery\Controllers;


use Archery\Models\Score;

class Welcome extends Base
{

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

        $this->render('Welcome', 'welcome.view', $viewData);
    }

    public function displayRules()
    {
        $this->render('Rules', 'rules.view');
    }

}

