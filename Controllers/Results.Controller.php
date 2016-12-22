<?php


namespace Archery\Controllers;

use Archery\Models\Score;
use Archery\Models\User;

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
            $viewData['scores'] = $score->all_getCWScores($_GET['week']);

            if (isset($_SESSION['id'])) {
                $user = new User();
                $viewData['archers'] = $user->getAllUsersForScoring();

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
            $archer = new User();
            $archerId = $archer->getUserByAnzNum($_POST['anz_num']);

            $score->setScore($archerId, $_POST['score'], $_POST['xcount'], $_POST['week'], $_POST['division']);
        }
        header("Location: /week?week=" . $_POST['week']);
        die();
    }


    /**
     * Adds a temp user to the users profile
     *  - 1 time use, removes after entering a score
     */
    public function addTempUser()
    {
        $user = new User();

        $anzNum = $user->getUserByAnzNum($_POST['anz_num']);
        if (isset($anzNum)) {
            $user->setAssociatedUser($_SESSION['id'], $anzNum, "TEMP");
        }

        header('location: /week?week=' . $_POST['week']);
        die();
    }



    public function ajaxSearchUserScoreWeekDiv()
    {
        $week = $_GET['week'];
        $div = $_GET['div'];
        $anz = $_GET['anz'];

        $score = new Score();

        $results = $score->liu_getCWAndBowTypeScores($week, $div, $anz);

        if (isset($results)) {return false;} else {return true;}

//        $this->renderAjax('searchresults.view', $results);
    }

}

