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
        }
        header("Location: /week?week=" . $_POST['week']);
        die();
    }




    public function ajaxSearchUserScoreWeekDiv()
    {
        $week = $_GET['week'];
        $div = $_GET['div'];

        $score = new Score();

        $results = $score->liu_getCWAndBowTypeScores($week, $div);
//
//        if (isset($hasUserScored[0])) {
//            $results = 'true';
//        } else {
//            $results = 'false';
//        }
        $this->renderAjax('searchresults.view', $results);
    }

}

