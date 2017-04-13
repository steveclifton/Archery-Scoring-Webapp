<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Score extends Base
{
    private $tableName = 'league_scores';

    /*********************************************************************************************
     *                                         Setters                                           *
     *********************************************************************************************/

    /*
     * Sets a score in the League Database for an Archer
     */
    public function setScore($eventNum, $archerId, $score, $xCount, $week, $div)
    {
        $entered = $_SESSION['id'];

        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");


        $sql = "INSERT INTO `$this->tableName` 
                                (`id`, `event`, `entered_by_id`,`user_id`, `score`, `xcount`, `week`, `division`, `created_at`) 
                            VALUES 
                                (NULL, '$eventNum', '$entered','$archerId', '$score', '$xCount', '$week', '$div', '$date');
               ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$eventNum, $entered, $archeryId, $score, $xCount, $week, $div, $date'));

        return true;
    }


    /**********************************************************************************************
     *                                       Getters                                              *
     **********************************************************************************************/

    /**
     * Logged In User Method
     *  Returns
     *   - Score
     *   - X-Count
     *   - Week
     */
    public function liu_getAllScores()
    {
        $loggedUser = $_SESSION['id'];


        $sql = "SELECT score, xcount, week, division 
                FROM `$this->tableName`
                WHERE `user_id` = '$loggedUser'
                ORDER BY `week` ASC 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$loggedUser'));

        $data = $stm->fetchAll();

        return $data;
    }



    /**
     * Returns an array of all those who have scores in a division
     */
    public function getAllDivisionArchers($eventNum, $div)
    {

        $sql = "SELECT DISTINCT user_id 
                FROM `$this->tableName` 
                WHERE `division` = '$div'
                AND `event` = '$eventNum'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        $archerList = array();
        foreach ($data as $d) {
            if (isset($d['user_id'])) {
                array_push($archerList, $d['user_id']);
            }
        }

        return $archerList;
    }




    /**
     * Gets the current weeks score for an Archer and Div
     */
    public function getCWScore($eventNum, $userId, $week, $div, $event)
    {

        $sql =  "SELECT * 
                 FROM `$this->tableName` 
                 WHERE week = '$week' 
                 AND user_id = '$userId' 
                 AND division = '$div'
                 AND event = '$eventNum'
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $week'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Counts the number of scores the user has for a div
     * - returns the number of rows
     */
    public function countUsersScores($eventNum, $userId, $div)
    {

        $sql =  "SELECT score 
                 FROM `$this->tableName` 
                 WHERE user_id = '$userId' 
                 AND division = '$div'
                 AND event = '$eventNum'
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $week'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        $num = count($data);

        return $num;

    }

    /**
     * All Users Method
     *  Returns
     *   - All user data and score date for a particular week
     */
    public function all_getCWScores($eventNum, $week)
    {

        $sql = "SELECT users.id, users.anz_num, users.prefered_type, users.first_name, users.last_name, `$this->tableName`.score, `$this->tableName`.xcount, `$this->tableName`.division  
                FROM `$this->tableName`
                INNER JOIN users ON `$this->tableName`.user_id = users.id  
                WHERE `$this->tableName`.week = '$week'
                AND event = '$eventNum'
                ORDER BY `$this->tableName`.score DESC, `$this->tableName`.xcount DESC
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$table, $week'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        $returnData['compound'] = array();
        $returnData['recurve'] = array();
        $returnData['recurve barebow'] = array();
        $returnData['longbow'] = array();

        $points = new Points();
        $handicap = new Handicap_Scores();
        foreach ($data as $d) {
            if ($d['division'] == 'compound'){
                $averageData = $handicap->getHandicapScores($d['id'], $week, 'compound');
                $d['average_score'] = $averageData['average_score'];
                $d['handicap_score'] = $averageData['handicap_score'];
                $archerPoints = $points->getWeekPoints($d['id'], $week, 'compound');
                $d['points'] = $archerPoints;
                array_push($returnData['compound'], $d);
            }

            else if ($d['division'] == 'recurve'){
                $averageData = $handicap->getHandicapScores($d['id'], $week, 'recurve');
                $d['average_score'] = $averageData['average_score'];
                $d['handicap_score'] = $averageData['handicap_score'];
                $archerPoints = $points->getWeekPoints($d['id'], $week, 'recurve');
                $d['points'] = $archerPoints;
                array_push($returnData['recurve'], $d);
            }

            else if ($d['division'] == 'recurve barebow'){
                $averageData = $handicap->getHandicapScores($d['id'], $week, 'recurve barebow');
                $d['average_score'] = $averageData['average_score'];
                $d['handicap_score'] = $averageData['handicap_score'];
                $archerPoints = $points->getWeekPoints($d['id'], $week, 'recurve barebow');
                $d['points'] = $archerPoints;
                array_push($returnData['recurve barebow'], $d);
            }

            else if ($d['division'] == 'longbow'){
                $averageData = $handicap->getHandicapScores($d['id'], $week, 'longbow');
                $d['average_score'] = $averageData['average_score'];
                $d['handicap_score'] = $averageData['handicap_score'];
                $archerPoints = $points->getWeekPoints($d['id'], $week, 'longbow');
                $d['points'] = $archerPoints;
                array_push($returnData['longbow'], $d);
            }
        }

        return $returnData;
    }


    /**
     * Returns all the scores for a user
     * - Ordered by score
     * - Creates and returns an average and Handicap Score
     * - Limit of 10 top scores and xcounts gathered
     */
    public function getTotalScoresAveraged($userId, $division)
    {


        $sql = "SELECT score, xcount 
                FROM `$this->tableName` 
                WHERE `user_id` = '$userId' 
                AND `division` LIKE '$division' 
                ORDER BY `score` DESC
                LIMIT 15
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        $addData = array();
        if (isset($data[0])) {
            $i = 0;
            $total = 0;
            $xCount = 0;
            foreach ($data as $d) {
                $total += $d['score'];
                $xCount += $d['xcount'];
                $i++;
            }
            $addData['average'] = round($total / $i, 1);
            $addData['xcount'] = round($xCount / $i, 0);

            return $addData;
        } else {
            return 0;
        }
    }

    /**
     * Logged In User Method
     *  Returns
     *   - All data from the round for a logged in users week
     */
    public function liu_getCWAndBowTypeScores($week, $division, $anz)
    {
        $user = new User();
        $userId = $user->getUserIdByAnzNum($anz);

        $sql =  "SELECT * 
                 FROM `$this->tableName` 
                 WHERE week='$week' 
                 AND user_id='$userId' 
                 AND division='$division'
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$table, $week, $division, $userId'));

        $data = $stm->fetchAll();


        return $data;
    }



    /*
    * Returns the top 10 scores for a user
    */
    public function getTop10Scores($eventNum, $userId, $div)
    {
        $sql = "SELECT `score`
                FROM `$this->tableName`
                WHERE `user_id` = '$userId'
                AND `division` = '$div'
                AND `event` = '$eventNum'
                ORDER BY `score` DESC
                LIMIT 10
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        $totalPoints = 0;
        foreach ($data as $d) {
//            print_r($d);
            $totalPoints += $d['score'];
        }

        return $totalPoints;

    }

    public function getAllScores($eventNum, $userId, $div)
    {
        $sql = "SELECT `score`
                FROM `$this->tableName`
                WHERE `user_id` = '$userId'
                AND `division` = '$div'
                AND `event` = '$eventNum'
                ORDER BY `score`
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
//
//        $totalPoints = 0;
//        foreach ($data as $d) {
//            $totalPoints += $d['score'];
//        }

        return $data;

    }


}