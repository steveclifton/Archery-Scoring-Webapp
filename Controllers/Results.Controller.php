<?php


namespace Archery\Controllers;

use Archery\Models\Score;

/**
 * Results Class
 *
 * Controllers results based queries
 */
class Results extends Base
{

    public function viewScores()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $score = new Score();
            if (!isset($_GET['week'])) {
                header('location: /welcome');
                die();
            }
            $viewData = $score->all_getCWScores($_GET['week']);
            
            if (isset($_SESSION['id'])) {
                $this->render('Scoring', 'week.view', $viewData);
                die();
            }
        }

        $this->render('Scoring', 'week.view', $viewData);
    }

    public function processScore()
    {
        $this->isNotLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $score = new Score();

            $score->liu_setScore($_POST['score'], $_POST['xcount'], $_POST['week'], $_POST['division']);

            $viewData = $score->all_getCWScores($_POST['week']);

            $userResults = $score->liu_getCWScore($_POST['week']);

        }
        header("Location: /week?week=" . $_POST['week']);
        die();
    }


}

