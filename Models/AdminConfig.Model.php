<?php

namespace Archery\Models;

use PDO;


/**
 * Class AdminConfig
 *
 * Class used to query the database for admin data
 *
 * @package
 */
class AdminConfig extends Base
{

    /**
     * Sets the admin config
     */
    public function setSetup($event, $currentWeek, $numWeeks)
    {
        date_default_timezone_set('NZ');
        $date = date("H:i:s d-m-Y");

        $sql = "INSERT INTO `admin_configuration` (`id`, `event`, `current_week`, `number_weeks`, `created_at`) 
                VALUES (NULL, '$event', '$currentWeek', '$numWeeks', '$date');
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event, $currentWeek, $numWeeks, $date'));

        return;
    }


    public function getCurrentSetup($event)
    {
        $sql = "SELECT `current_week`, `number_weeks` 
                FROM `admin_configuration` 
                WHERE `event` = '$event'
                ORDER BY created_at DESC
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        if (isset($data[0])) {
            return $data[0];
        }
        header('location: /welcome');
        die();
    }


    /**
     * Returns the current week
     */
    public function getCurrentWeek($event)
    {
        $sql = "SELECT `current_week` FROM `admin_configuration` WHERE `event` = '$event' ORDER BY `id` DESC LIMIT 1";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        if (isset($data[0]['current_week'])) {
            return $data[0]['current_week'];
        }
        header('location: /welcome');
        die();
    }

    /**
     * Returns the number of weeks the event goes for
     */
    public function getNumWeeks($event)
    {
        $sql = "SELECT `number_weeks` FROM `admin_configuration` WHERE `event` = '$event' ORDER BY `created_at` DESC LIMIT 1";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['number_weeks'])) {
            return $data[0]['number_weeks'];
        }
        header('location: /welcome');
        die();
    }

    public function getCurrentUsers()
    {
        $sql = "SELECT id, anz_num, first_name, last_name FROM `users` ORDER by id";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$event'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0])) {
            return $data;
        } else {
            return false;
        }

    }



}
