<?php

namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Points extends Base
{

    /**
     * Sets the weekly points
     */
    public function setWeeklyPoints($userId, $week, $div, $points)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `2017_outdoor_points` (`id`, `user_id`, `week`, `division`, `points`, `created_at`) 
                VALUES (NULL, '$userId', '$week', '$div', '$points', '$date');";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $week, $div, $points'));

        return true;
    }


    /**
     * Returns the Archers top ten points tallied
     */
    public function getArchersTopTen($userId, $div)
    {
        $table = '2017_outdoor_point_totals';

        $sql = "SELECT top_ten_points, user_id, division, `users`.first_name, `users`.last_name, `users`.anz_num 
                FROM `$table`
                WHERE `user_id` = '$userId'
                AND `division` = '$div'
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getArchersTotalPoints($userId, $div)
    {
        $sql = "SELECT points 
                FROM `2017_outdoor_points`
                WHERE `user_id` = '$userId'
                AND `division` = '$div'
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


    /**
     * Sets a users total points in the database
     */
    public function setTotalPoints($userId, $div, $points)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");
        $table = '2017_outdoor_point_totals';

        $sql = "INSERT INTO `2017_outdoor_point_totals` (`id`, `user_id`, `division`, `top_ten_points`, `created_at`) 
                VALUES (NULL, '$userId', '$div', '$points', '$date');";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$userId, $div, $points'));

        return true;
    }




    /**
     * Returns the top ten points for
     *  - All archers in a DIV
     *  - For the week
     */
    public function getTopTenPoints($div)
    {
        $table = '2017_outdoor_point_totals';

        $score = new Score();

        $archerList = $score->getAllDivisionArchers($div);

        $pointList = array();
        foreach ($archerList as $archer) {

            $sql = "SELECT top_ten_points, `users`.first_name, `users`.last_name
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
                array_push($pointList, $data[0]);
            }
        }

        rsort($pointList);

        return $pointList;
    }


}