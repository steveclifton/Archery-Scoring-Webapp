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

    public function liu_setScore($score, $xCount, $date)
    {
        $user = $_SESSION['id'];

        $sql = "INSERT INTO `30m_round` 
                                (`id`, `user_id`, `score`, `xcount`, `date_shot`, `created_at`) 
                            VALUES 
                                (NULL, '$user', '$score', '$xCount', '$date', CURRENT_TIMESTAMP);
               ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$score, $xCount, $date'));

        return true;
    }

    public function setMultipleScores($enteries)
    {
        // Here club sect can enter multiple scores for multiple archers
    }


    /**********************************************************************************************
     *                                       Getters                                              *
     **********************************************************************************************/

    public function liu_getAllScores()
    {
        $loggedUser = $_SESSION['id'];

        $sql = " SELECT * FROM `30m_round` WHERE user_id='$loggedUser' ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$loggedUser'));

        $data = $stm->fetchAll();

        var_dump($data);
        die();
        // return $data;
    }

    public function liu_getCWScore()
    {
        // Gets the current weeks score for the logged in user
    }

    public function all_getCWScores()
    {
        // Gets all scores from the current week
    }

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