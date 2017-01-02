<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;


/**
 * Terms
 *        - CW - Current Week
 *        - LIU - Logged In User
 *        - GOU - Group Of Users
 *        - ALL - All Active Users
 *        - SFU - Specific User
 *
 */


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

        $table = $this->tableName;

        $sql = "INSERT INTO `$table` 
                                (`id`, `entered_by_id`,`user_id`, `score`, `xcount`, `week`, `division`, `created_at`) 
                            VALUES 
                                (NULL, '$entered','$archerId', '$score', '$xCount', '$week', '$div', CURRENT_TIMESTAMP);
               ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$entered, $archeryId, $score, $xCount, $week, $div'));

        return true;
    }

    public function setMultipleScores($enteries)
    {
        // Here club sect can enter multiple scores for multiple archers
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
    public function getCWScore($userId, $week, $div)
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

        $data = $stm->fetchAll();

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

        $sql = "SELECT * 
                FROM `$table`
                INNER JOIN users 
                ON `$table`.user_id = users.id
                WHERE `$table`.week = '$week'
                ORDER BY `$table`.score DESC 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$week'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);



        $returnData['compound'] = array();
        $returnData['recurve'] = array();
        $returnData['recurve_bb'] = array();
        $returnData['crossbow'] = array();
        $returnData['longbow'] = array();
        foreach ($data as $d) {
            if ($d['division'] == 'compound'){
                array_push($returnData['compound'], $d);
            } else if ($d['division'] == 'recurve'){
                array_push($returnData['recurve'], $d);
            } else if ($d['division'] == 'crossbow'){
                array_push($returnData['crossbow'], $d);
            } else if ($d['division'] == 'recurve_bb'){
                array_push($returnData['recurve_bb'], $d);
            } else if ($d['division'] == 'longbow'){
                array_push($returnData['longbow'], $d);
            }
        }

        return $returnData;
    }


    /**
     * Specific User Method
     *  Returns
     *   - All user data and score data for a specific user and week
     */
    public function sfu_getAllScores($userId, $week)
    {
        $table = $this->tableName;

        $sql = "SELECT * 
                FROM `$table`
                INNER JOIN users 
                ON `$table`.user_id = '$userId'
                WHERE `$table`.week = '$week'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $week'));

        $data = $stm->fetchAll();

        return $data;
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




    public function gou_getAllScores($userId)
    {
        $table = $this->tableName;
        $sql = " SELECT * 
                 FROM `$table` 
                 WHERE user_id='$userId' 
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId'));

        $data = $stm->fetchAll();

        var_dump($data);
        die();
        return $data;
    }


    public function getGroupOfScores($userList)
    {
        // here is where a club sec could request all the scores for their shooters

    }

}