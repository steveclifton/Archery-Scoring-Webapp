<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Handicap_Scores extends Base
{

    private $table = 'league_handicap_data';

    /**
     * Sets an Archers handicap and averages into the database
     */
    public function setHandicap($event, $archerId, $week, $weekScore, $div, $average, $averageX, $handicap, $handicapScore, $top10)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `$this->table` (`id`, `event`, `user_id`, `week`, `week_score`, `division`, `average_score`, `average_x`, `handicap`, `handicap_score`, `top10`, `created_at`) 
                VALUES (NULL, '$event', '$archerId', '$week', '$weekScore', '$div', '$average', '$averageX', '$handicap', '$handicapScore', '$top10', '$date');";


        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$archerId, $week, $weekScore, $div, $average, $averageX, $handicap, $handicapScore, $top10'));

        return true;
    }


    public function getAllAverages($event, $div)
    {

        $score = new Score();

        // TODO

        $archerList = $score->getAllDivisionArchers(3, $div);

        $averageList = array();

        foreach ($archerList as $archer) {
            $sql = "SELECT user_id, top10, average_score, division, average_x, `users`.first_name, `users`.last_name
                    FROM `$this->table`
                    JOIN `users` ON `$this->table`.user_id = `users`.id
                    WHERE `user_id` = '$archer'
                    AND `division` = '$div'
                    AND `event` = '$event'
                    ORDER BY `$this->table`.id DESC
                    LIMIT 1
                    ";

            $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (isset($data[0])) {
                unset($data[0]['user_id']);
                array_push($averageList, $data[0]);
            }
        }

        // Sorts the array by average_score
        rsort($averageList);

        return $averageList;

    }

    /**
     * Returns the handicap scores for a user
     */
    public function getHandicapScores($userId, $week, $div)
    {
        $sql = "SELECT average_score, handicap_score 
                FROM `$this->table` 
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






    // Returns all the current weeks scores for handicap point calcs
    //
    public function all_getHandicapForPoints($event, $week)
    {

        $sql = "SELECT user_id, division, average_score, handicap_score
                FROM `$this->table`
                JOIN `users` ON `$this->table`.user_id = `users`.id
                AND `week` = '$week'
                AND `event` = '$event'
                ORDER BY `handicap_score` DESC, `average_score` DESC 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        $returnData['compound'] = array();
        $returnData['recurve'] = array();
        $returnData['recurve barebow'] = array();
        $returnData['longbow'] = array();
        foreach ($data as $d) {
            if ($d['division'] == 'compound'){
                array_push($returnData['compound'], $d);
            }

            else if ($d['division'] == 'recurve'){
                array_push($returnData['recurve'], $d);
            }

            else if ($d['division'] == 'recurve barebow'){
                array_push($returnData['recurve barebow'], $d);
            }

            else if ($d['division'] == 'longbow'){
                array_push($returnData['longbow'], $d);
            }
        }

        return $returnData;

    }


}