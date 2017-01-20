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
    public function ajax_processScore()
    {
        $score = new Score();
        $user = new User();
        $archer = $_POST['archer'];

        $userId = $user->getUserIdByAnzNum($archer['anz']);
        $existingScore = $score->getCWScore($userId, $archer['week'], $archer['div']);
        if (!isset($existingScore[0])) {
            $score->setScore($userId, $archer['score'], $archer['xcount'], $archer['week'], $archer['div']);
            echo json_encode(array('status' => 'passed', 'message' => 'Score entered'));
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Score already entered'));
        }


        die();


            // Removes the association of temp users
            $tempAssoc = $archer->checkAssociation($_SESSION['id'], $archerId);
            if (isset($tempAssoc[0]) && $tempAssoc[0]['status'] == 'TEMP') {
                $archer->removeAssociation($_SESSION['id'], $archerId);
            }

    }


    /**
     * Adds a temp user to the users profile
     *  - 1 time use, removes after entering a score
     */
    public function ajax_addTempUser()
    {

        $user = new User();

        $anzNum = $user->getUserIdByAnzNum($_POST['anz_num']);
        if (isset($anzNum)) {
            $result = $user->checkAssociation($_SESSION['id'], $anzNum);
            if (!isset($result[0])) {
                $result = $user->setAssociatedUser($_SESSION['id'], $anzNum, "TEMP");
                echo json_encode(array("status" => "success", "message" => "added")); die();
            }
        }
        echo json_encode(array("status" => "failed", "message" => "Could Not Add Association")); die();

    }


    /**
     * Ajax searches whether the ANZ number exists or not
     */
    public function getUserByAnz()
    {
        $anzNum = $_GET['anz_num'];

        if ($anzNum == '') {
            return;
        }

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

