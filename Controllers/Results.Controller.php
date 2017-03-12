<?php


namespace Archery\Controllers;

use Archery\Models\AdminConfig;
use Archery\Models\Handicap_Scores;
use Archery\Models\Points;
use Archery\Models\PointTotals;
use Archery\Models\Score;
use Archery\Models\Scores;
use Archery\Models\User;

/**
 * Results Class
 *
 * Controllers results based queries
 */
class Results extends Base
{

    /**
     * Gets the weeks scores and passes to view to be displayed
     */
    public function viewScores()
    {
        $user = new User();
        $score = new Score();
        $setup = new AdminConfig();
        $currentWeek = $setup->getCurrentWeek();

        if (isset($_GET['week']) && is_numeric($_GET['week'])) {
            if (isset($_SESSION['id'])) {
                $user = new User();
                $viewData['archers'] = $user->getAllUsersForScoring();
                if ($_GET['week'] == $_SESSION['current_week']) {
                    $viewData['canScore'] = true;
                }
            }
            $viewData['weekRequested'] = $_GET['week'];
            $viewData['scores'] = $score->all_getCWScores($_GET['week']);
        } else {
            if (isset($_SESSION['id'])) {
                $viewData['archers'] = $user->getAllUsersForScoring();
            }
            $viewData['scores'] = $score->all_getCWScores($currentWeek);
            $viewData['canScore'] = true;
        }

        $viewData['current_week'] = $currentWeek;

        $this->render('Weekly Scores', 'week.view', $viewData);
        die();

    }




    /*
     * Controller to view all the Points and Averages for the League Series
     */
    public function viewOverallScores()
    {
        if (isset($_POST['division'])) {
            $division = $_POST['division'];
            if ($division == 'recurvebb') {
                $division = 'recurve barebow';
            }
        } else {
            $division = 'compound';
        }


        $points = new Points();
        $averages = new Handicap_Scores();
        $admin = new AdminConfig();
        $week = $admin->getCurrentWeek();

        $viewData['points'] = $points->getTopTenPoints(2, $division);


        $viewData['averages'] = $averages->getAllAverages(2, $division);

        $this->render('Weekly Scores', 'overall.view', $viewData);
        die();

    }




    /**
     * Method for Ajax to update the averages/points
     */
    public function ajax_viewOverall()
    {
        if (isset($_POST['division'])) {
            $division = $_POST['division'];
            if ($division == 'recurvebb') {
                $division = 'recurve barebow';
            }
        } else {
            $division = 'compound';
        }

        $points = new Points();
        $averages = new Handicap_Scores();
        $admin = new AdminConfig();
        $week = $admin->getCurrentWeek();

        $overallPoints = $points->getTopTenPoints(2, $division);
        $overallAverage = $averages->getAllAverages(2, $division);


        echo json_encode(array('status' => 'success', 'averages' => $overallAverage, 'points' => $overallPoints));

    }

    /**
     * Processes score for a weeks view submission
     */
    public function ajax_processScore()
    {
        $score = new Score();
        $user = new User();
        $hCap = new Handicap_Scores();
        $archer = $_POST['archer'];

        $userId = $user->getUserIdByAnzNum($archer['anz']);
        $existingScore = $score->getCWScore($userId, $archer['week'], $archer['div'], '2017_outdoor_league');


        if (!isset($existingScore[0])) {
            $score->setScore($userId, $archer['score'], $archer['xcount'], $archer['week'], $archer['div']);
            $average = $score->getTotalScoresAveraged($userId, $archer['div']);
            $averageScore = $average['average'];
            $averageX = $average['xcount'];

            $handicap = 360 - $averageScore;
            $handicapScore = $archer['score'] + $handicap;

            $hCap->setHandicap(2, $userId, $archer['week'], $archer['score'], $archer['div'], $averageScore, $averageX, $handicap, $handicapScore);

            $divScores = $score->all_getCWScores($archer['week']);

            echo json_encode(array('status' => 'passed', 'message' => 'Score entered', 'allScores' => $divScores[$archer['div']]));
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Score already entered'));
        }

        // Removes the association of temp users
        $tempAssoc = $user->checkAssociation($_SESSION['id'], $userId);

        if (isset($tempAssoc[0]) && $tempAssoc[0]['status'] == 'TEMP') {
            $user->removeAssociation($_SESSION['id'], $userId);
        }
        die();
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
                echo json_encode(array("status" => "success", "message" => "added"));
                die();
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
     * Used to check whether an archer has a score for that week and division or not
     */
    public function ajaxSearchUserScoreWeekDiv()
    {
        $week = $_GET['week'];
        $div = $_GET['div'];
        $anz = $_GET['anz'];

        $score = new Score();

        $results = $score->liu_getCWAndBowTypeScores($week, $div, $anz);

        if (isset($results)) {
            return false;
        } else {
            return true;
        }

    }

}

