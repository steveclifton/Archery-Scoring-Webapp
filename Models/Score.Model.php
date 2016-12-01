<?php

namespace Archery\Models;

use Archery\Exceptions\CustomException;

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

    /*********************************************************************************************
     *                                         Setters                                           *
     *********************************************************************************************/

    public function liu_setScore($score, $xCount, $week)
    {
        $user = $_SESSION['id'];

        $sql = "INSERT INTO `30m_round` 
                                (`id`, `entered_by_id`,`user_id`, `score`, `xcount`, `week`, `created_at`) 
                            VALUES 
                                (NULL, '$user','$user', '$score', '$xCount', '$week' ,CURRENT_TIMESTAMP);
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
     */
    public function liu_getAllScores()
    {
        $loggedUser = $_SESSION['id'];

        $sql = " SELECT * FROM `30m_round` WHERE user_id='$loggedUser' ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$loggedUser'));

        $data = $stm->fetchAll();

        return $data;
    }


    /**
     * Logged In User Method
     */
    public function liu_getCWScore($week)
    {
        $loggedUser = $_SESSION['id'];

        $sql = " SELECT * FROM `30m_round` WHERE week='$week' AND user_id='$loggedUser' ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$week'));

        $data = $stm->fetchAll();

        return $data;
    }



    public function all_getCWScores($week)
    {
        $sql = "
                SELECT * 
                FROM 30m_round
                INNER JOIN users 
                ON 30m_round.user_id = users.id
                WHERE 30m_round.week = '$week'
                ";
        //$sql = " SELECT * FROM `30m_round` JOIN `users` WHERE week='$week' ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$week'));

        $data = $stm->fetchAll();

        return $data;
    }


    /**
     * Specific User Method
     */
    public function sfu_getAllScores($userId)
    {
        $sql = " SELECT * FROM `30m_round` WHERE user_id='$userId' ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId'));

        $data = $stm->fetchAll();

        var_dump($data);
        die();
        return $data;
    }

    public function gou_getAllScores($userId)
    {
        $sql = " SELECT * FROM `30m_round` WHERE user_id='$userId' ";

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