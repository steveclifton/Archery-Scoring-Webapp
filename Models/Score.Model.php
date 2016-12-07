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

    public function liu_setScore($score, $xCount, $week, $div)
    {
        $user = $_SESSION['id'];
        $table = $this->tableName;

        $sql = "INSERT INTO `$table` 
                                (`id`, `entered_by_id`,`user_id`, `score`, `xcount`, `week`, `division`, `created_at`) 
                            VALUES 
                                (NULL, '$user','$user', '$score', '$xCount', '$week', '$div', CURRENT_TIMESTAMP);
               ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$score, $xCount'));

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

        $sql = "SELECT score, xcount, week 
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
    public function liu_getCWScore($week)
    {
        $loggedUser = $_SESSION['id'];
        $table = $this->tableName;

        $sql =  "SELECT * 
                 FROM `$table` 
                 WHERE week='$week' 
                 AND user_id='$loggedUser' 
                 ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$week'));

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

        $data = $stm->fetchAll();

        return $data;
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