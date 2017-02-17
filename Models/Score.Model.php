<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Score extends Base
{
    private $tableName;

    public function __construct()
    {
        parent::__CONSTRUCT();
        $name = new Event();
        $this->tableName = $name->getTableName();
    }


    /*********************************************************************************************
     *                                         Setters                                           *
     *********************************************************************************************/

    public function setScore($archerId, $score, $xCount, $week, $div)
    {
        $entered = $_SESSION['id'];

        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $table = $this->tableName;

        $sql = "INSERT INTO `$table` 
                                (`id`, `entered_by_id`,`user_id`, `score`, `xcount`, `week`, `division`, `created_at`) 
                            VALUES 
                                (NULL, '$entered','$archerId', '$score', '$xCount', '$week', '$div', '$date');
               ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$entered, $archeryId, $score, $xCount, $week, $div, $date'));

        return true;
    }

    /**
     *
     */
    public function setHandicap($archerId, $week, $weekScore, $div, $average, $handicap, $handicapScore)
    {
        $table = $this->tableName;

        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `handicap_scores` (`id`, `user_id`, `week`, `week_score`, `division`, `average`, `handicap`, `handicap_score`, `created_at`) 
                VALUES (NULL, '$archerId', '$week', '$weekScore', '$div', '$average', '$handicap', '$handicapScore', '$date');";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$archerId, $week, $weekScore, $div, $average, $handicap, $handicapScore'));

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
        $table = $this->tableName;

        $sql = "SELECT score, xcount, week, division 
                FROM `$table`
                WHERE `user_id` = '$loggedUser'
                ORDER BY `week` ASC 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$loggedUser'));

        $data = $stm->fetchAll();

        return $data;
    }


    /**
     * Logged In User Method
     *  Returns
     *   - All data from the round for a logged in users week
     */
    public function getCWScore($userId, $week, $div, $event)
    {
        $table = $this->tableName;

        $sql =  "SELECT * 
                 FROM `$table` 
                 WHERE week='$week' 
                 AND user_id='$userId' 
                 AND division='$div'
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $week'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }


    /**
     * All Users Method
     *  Returns
     *   - All user data and score date for a particular week
     */
    public function all_getCWScores($week)
    {
        $table = $this->tableName;

        $sql = "SELECT users.id, users.anz_num, users.prefered_type, users.first_name, users.last_name, `$table`.score, `$table`.xcount, `$table`.division  
                FROM `$table`
                INNER JOIN users ON `$table`.user_id = users.id
                WHERE `$table`.week = '$week'
                ORDER BY `$table`.score DESC, `$table`.xcount DESC
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$table, $week'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        /**
         * TODO
         */
        $returnData['compound'] = array();
        $returnData['recurve'] = array();
        $returnData['recurve barebow'] = array();
        $returnData['longbow'] = array();
        foreach ($data as $d) {
            if ($d['division'] == 'compound'){
                $averageData = $this->getHandicapScores($d['id'], $week, 'compound');
                $d['average'] = $averageData['average'];
                $d['handicap_score'] = $averageData['handicap_score'];
                array_push($returnData['compound'], $d);
            }

            else if ($d['division'] == 'recurve'){
                $averageData = $this->getHandicapScores($d['id'], $week, 'recurve');
                $d['average'] = $averageData['average'];
                $d['handicap_score'] = $averageData['handicap_score'];
                array_push($returnData['recurve'], $d);
            }

            else if ($d['division'] == 'recurve barebow'){
                $averageData = $this->getHandicapScores($d['id'], $week, 'recurve barebow');
                $d['average'] = $averageData['average'];
                $d['handicap_score'] = $averageData['handicap_score'];
                array_push($returnData['recurve barebow'], $d);
            }

            else if ($d['division'] == 'longbow'){
                $averageData = $this->getHandicapScores($d['id'], $week, 'longbow');
                $d['average'] = $averageData['average'];
                $d['handicap_score'] = $averageData['handicap_score'];
                array_push($returnData['longbow'], $d);
            }
        }

        return $returnData;
    }

    public function getHandicapScores($userId, $week, $div)
    {
        $sql = "SELECT average, handicap_score 
                FROM `handicap_scores` 
                WHERE `user_id` = '$userId'
                AND `week` = '$week'
                AND `division` = '$div'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        if (isset($data[0])) {
            return $data[0];
        } else {
            return false;
        }
    }


    /**
     * Returns all the scores for a user
     * - Ordered by score
     * - Creates and returns an average and Handicap Score
     */
    public function getTotalScoresAveraged($userId, $division)
    {
        $table = $this->tableName;

        $sql = "SELECT score 
                FROM `$table` 
                WHERE `user_id` = '$userId' 
                AND `division` LIKE '$division' 
                ORDER BY `score` DESC
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0])) {
            $i = 0;
            $total = 0;
            foreach ($data as $d) {
                $total += $d['score'];
                $i++;
            }
            $admin = new AdminConfig();
            $data['average'] = round($total / $i, 1);
            return $data;
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
        $table = $this->tableName;
        $user = new User();
        $userId = $user->getUserIdByAnzNum($anz);

        $sql =  "SELECT * 
                 FROM `$table` 
                 WHERE week='$week' 
                 AND user_id='$userId' 
                 AND division='$division'
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$table, $week, $division, $userId'));

        $data = $stm->fetchAll();


        return $data;
    }




}