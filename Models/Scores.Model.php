<?php


namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Scores extends Base
{

    public function getScore()
    {

    }

    public function setScore($event, $round, $userId, $division, $score1Data, $score2Data, $score3Data, $score4Data, $totalData)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `scores` (`id`, `event`, `round`, `user_id`, `division`, 
                                      `score_1`, `score_1_x`, `score_1_hits`, `score_1_10s`, 
                                      `score_2`, `score_2_x`, `score_2_hits`, `score_2_10s`, 
                                      `score_3`, `score_3_x`, `score_3_hits`, `score_3_10s`, 
                                      `score_4`, `score_4_x`, `score_4_hits`, `score_4_10s`,
                                      `total_score`, `total_x`, `total_hits`, `total_10s`,
                                      `created_at`) 
                                    VALUES (NULL, 
                                            '$event', 
                                            '$round', 
                                            '$userId', 
                                            '$division', 
                                            '$score1Data[0]', 
                                            '$score1Data[1]', 
                                            '$score1Data[2]', 
                                            '$score1Data[3]', 
                                            '$score2Data[0]', 
                                            '$score2Data[1]', 
                                            '$score2Data[2]', 
                                            '$score2Data[3]',
                                            '$score3Data[0]', 
                                            '$score3Data[1]', 
                                            '$score3Data[2]', 
                                            '$score3Data[3]', 
                                            '$score4Data[0]', 
                                            '$score4Data[1]', 
                                            '$score4Data[2]', 
                                            '$score4Data[3]',
                                            '$totalData[0]',
                                            '$totalData[1]',
                                            '$totalData[2]',
                                            '$totalData[3]',
                                            '$date'
                                            )
        ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event, $round, $userId, $division, $scoreData'));

        return true;



    }
}