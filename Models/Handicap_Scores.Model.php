<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Handicap_Scores extends Base
{

    public function getAllAverages($div)
    {
        $table = '2017_outdoor_handicap_scores';

        $score = new Score();

        $archerList = $score->getAllDivisionArchers($div);

        $averageList = array();
        foreach ($archerList as $archer) {
            $sql = "SELECT user_id, average_score, division, average_x, `users`.first_name, `users`.last_name
                    FROM `$table`
                    JOIN `users` ON `$table`.user_id = `users`.id
                    WHERE `user_id` = '$archer'
                    ORDER BY `$table`.id DESC
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

    // Returns all the current weeks scores for handicap point calcs
    //
    public function all_getHandicapForPoints($week)
    {
        $table = '2017_outdoor_handicap_scores';

        $sql = "SELECT user_id, division, average_score, handicap_score
                FROM `$table`
                JOIN `users` ON `$table`.user_id = `users`.id
                AND `week` = '$week'
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