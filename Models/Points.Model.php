<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Points extends Base
{
    private $pointsTable = 'league_points';
    private $pointsTotalTable = 'league_point_totals';


    /**
     * Sets the weekly points
     */
    public function setWeeklyPoints($event, $userId, $week, $div, $points)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `$this->pointsTable` (`id`, `event`, `user_id`, `week`, `division`, `points`, `created_at`) 
                VALUES (NULL, '$event', '$userId', '$week', '$div', '$points', '$date');";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event, $userId, $week, $div, $points'));

        return true;
    }

    /**
     * Gets an archers top 10 points
     */
    public function getArchersTotalPoints($event, $userId, $div)
    {
        $sql = "SELECT points 
                FROM `$this->pointsTable`
                WHERE `user_id` = '$userId'
                AND `division` = '$div'
                AND `event` = '$event'
                ORDER BY `points`
                LIMIT 10
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        $totalPoints = 0;
        foreach ($data as $d) {
            $totalPoints += $d['points'];
        }

        return $totalPoints;
    }

//
//    /**
//     * Returns the Archers top ten points tallied
//     */
//    public function getArchersTopTen($event, $userId, $div)
//    {
//
//        $sql = "SELECT top_ten_points, user_id, division, `users`.first_name, `users`.last_name, `users`.anz_num
//                FROM `$this->pointsTotalTable`
//                WHERE `user_id` = '$userId'
//                AND `division` = '$div'
//                AND `event` = '$event'
//                LIMIT 1
//                ";
//
//        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
//
//        $stm->execute();
//
//        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
//
//        return $data;
//    }


    /**
     * Sets a users total points in the database
     */
    public function setTotalPoints($event, $userId, $div, $points, $week)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `$this->pointsTotalTable` (`id`, `event`, `user_id`, `division`, `top_ten_points`, `week_entered`, `created_at`) 
                VALUES (NULL, '$event', '$userId', '$div', '$points', '$week', '$date');
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event, $userId, $div, $points'));

        return true;
    }




    /**
     * Returns the top ten points for
     *  - All archers in a DIV
     *  - For the week
     *
     * Sorts them by the top ten points
     */
    public function getTopTenPoints($event, $div)
    {

        $score = new Score();

        // GET EVENT NUMBER HERE

        $archerList = $score->getAllDivisionArchers(2, $div);

        $pointList = array();
        foreach ($archerList as $archer) {

            $sql = "SELECT top_ten_points, `users`.first_name, `users`.last_name
                    FROM `$this->pointsTotalTable`
                    JOIN `users` ON `$this->pointsTotalTable`.user_id = `users`.id
                    WHERE `user_id` = '$archer'
                    AND `division` = '$div'
                    AND `event` = '$event'
                    ORDER BY `$this->pointsTotalTable`.id DESC
                    LIMIT 1
                    ";

            $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (isset($data[0])) {
                array_push($pointList, $data[0]);
            }
        }

        rsort($pointList);

        return $pointList;
    }


    /**
     * Returns the points for a user, week and div
     */
    public function getWeekPoints($userId, $week, $div)
    {
        $sql = "SELECT points
                FROM `$this->pointsTable` 
                WHERE `user_id` = '$userId'
                AND `week` = '$week'
                AND `division` = '$div'
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $week, $div'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        if (isset($data[0])) {
            if (isset($data[0]['points'])) {
                return $data[0]['points'];
            }
        }

        return 0;

    }



}