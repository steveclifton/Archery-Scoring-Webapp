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
            if (!isset($_GET['week'])) {
                header('location: /welcome');
                die();
            }
            $score = new Score();
            $viewData['scores'] = $score->all_getCWScores($_GET['week']);

            if (isset($_SESSION['id'])) {
                $user = new User();
                $viewData['archers'] = $user->getAllUsersForScoring();

                $this->render('Scoring', 'week.view', $viewData);
                die();
            }
        } else {
            header('location: /welcome');
            die();
        }

        $this->render('Scoring', 'week.view', $viewData);
    }

    /**
     * Processes score for a weeks view submission
     */
    public function processScore()
    {
        $this->isNotLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $score = new Score();
            $archer = new User();
            $archerId = $archer->getUserIdByAnzNum($_POST['anz_num']);

            // validate score

            if (is_numeric($_POST['score']) || is_numeric($_POST['xcount'])) {
                if ($_POST['score'] >= 0 && $_POST['score'] <= 360 && $_POST['xcount'] >= 0 && $_POST['xcount'] <= 36) {
                    // check to see if a score already exists
                    $existingScore = $score->getCWScore($archerId, $_POST['week'], $_POST['division']);
                    // if a score doesnt exist, create one
                    if (!isset($existingScore[0])) {
                        $score->setScore($archerId, $_POST['score'], $_POST['xcount'], $_POST['week'], $_POST['division']);
                    } else {
                        $_SESSION['invalidscore'] = "*Score already entered";
                        header("Location: /week?week=" . $_POST['week']);
                    }
                }
            } else {
                $_SESSION['invalidscore'] = "*Invalid score";
                header("Location: /week?week=" . $_POST['week']);
            }

            // Removes the association of temp users
            $tempAssoc = $archer->checkAssociation($_SESSION['id'], $archerId);
            if (isset($tempAssoc[0]) && $tempAssoc[0]['status'] == 'TEMP') {
                $archer->removeAssociation($_SESSION['id'], $archerId);
            }
            
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

        $anzNum = $user->getUserIdByAnzNum($_POST['anz_num']);
        if (isset($anzNum)) {
            $result = $user->checkAssociation($_SESSION['id'], $anzNum);
            if (!isset($result[0])) {
                $user->setAssociatedUser($_SESSION['id'], $anzNum, "TEMP");
            }
        }

        header('location: /week?week=' . $_POST['week']);
        die();
    }


    /**
     * Ajax searches whether the ANZ number exists or not
     */
    public function getUserByAnz()
    {
        $anzNum = $_GET['anz_num'];

        $user = new User();

        $existingUser = $user->getUserIdByAnzNum($anzNum);

        header('Content-Type: application/json');

        if (!$existingUser) {
            echo json_encode(array("status" => "failed", "message" => "user not found"));// "ANZ number not found";
        } else if (is_numeric($existingUser)){
            echo json_encode(array("status" => "success", "message" => "user found"));//echo "Found user";
        }

        return;
    }





    /**
     * Working on this later
     */
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

