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
     * @param string $event
     */
    public function viewScores($event = '')
    {
        $user = new User();
        $score = new Score();
        $setup = new AdminConfig();
        // TODO
        $currentWeek = $setup->getCurrentWeek(3);

        if (isset($_GET['week']) && is_numeric($_GET['week'])) {
            if (isset($_SESSION['id'])) {
                $user = new User();
                $viewData['archers'] = $user->getAllUsersForScoring();
                if ($_GET['week'] == $_SESSION['current_week']) {
                    $viewData['canScore'] = true;
                    //todo enable this
                }
            }
            $viewData['weekRequested'] = $_GET['week'];
            // TODO
            $viewData['scores'] = $score->all_getCWScores(3, $_GET['week']);
        } else {
            header('Location: /');
            die();
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

        // TODO
        $viewData['points'] = $points->getTopTenPoints(3, $division);

        // TODO
        $viewData['averages'] = $averages->getAllAverages(3, $division);

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

        // TODO
        $week = $admin->getCurrentWeek(3);

        // TODO
        $overallPoints = $points->getTopTenPoints(3, $division);
        $overallAverage = $averages->getAllAverages(3, $division);


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

        // TODO
        $existingScore = $score->getCWScore(3, $userId, $archer['week'], $archer['div']);


        if (!isset($existingScore[0])) {

            // TODO
            $score->setScore(3, $userId, $archer['score'], $archer['xcount'], $archer['week'], $archer['div']);

            $average = $score->getTotalScoresAveraged($userId, $archer['div']);
            $averageScore = $average['average'];
            $averageX = $average['xcount'];

            $handicap = 300 - $averageScore;
            $handicapScore = $archer['score'] + $handicap;

            // TODO
            $best10 = $score->getTop10Scores(3, $userId, $archer['div']);

            // TODO
            $hCap->setHandicap(3, $userId, $archer['week'], $archer['score'], $archer['div'], $averageScore, $averageX, $handicap, $handicapScore, $best10);

            // TODO
            $divScores = $score->all_getCWScores(3, $archer['week']);

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

    public function ajax_editUsersScore()
    {
        $admin = new AdminConfig();
        $week = $admin->getCurrentWeek(3);

        $user = new User();
        $userId = $user->getUserIdByAnzNum($_POST['anznum']);

        $score = new Score();
        $result = $score->getAllCurrentWeekScores($userId, $week, 3);


        echo json_encode(array("status" => "success", "results" => $result));


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

