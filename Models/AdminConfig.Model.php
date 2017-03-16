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


    /**
     * Returns the current week
     */
    public function getCurrentWeek()
    {
        $sql = "SELECT `current_week` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

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
    public function getNumWeeks()
    {
        $sql = "SELECT `number_weeks` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['number_weeks'])) {
            return $data[0]['number_weeks'];
        }
        header('location: /welcome');
        die();
    }

    /**
     * Returns the current Event name
     */
    public function getCurrentEvent()
    {
        $sql = "SELECT `current_event` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['current_event'])) {
            return $data[0]['current_event'];
        }
        header('location: /welcome');
        die();
    }

    /**
     * Returns the current round name
     */
    public function getCurrentRound()
    {
        $sql = "SELECT `current_round` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['current_round'])) {
            return $data[0]['current_round'];
        }
        header('location: /welcome');
        die();
    }

    /**
     * Returns the current DB in use
     */
    public function getCurrentDB()
    {
        $sql = "SELECT `table_name` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['table_name'])) {
            return $data[0]['table_name'];
        }
        header('location: /welcome');
        die();
    }

    /**
     * Returns the current max score
     */
    public function getCurrentMaxScore()
    {
        $sql = "SELECT `max_score` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['max_score'])) {
            return $data[0]['max_score'];
        }
        header('location: /welcome');
        die();
    }

    /**
     * Returns the current max X-Count
     */
    public function getCurrentMaxXCount()
    {
        $sql = "SELECT `max_xcount` 
                FROM `admin_configuration` 
                ORDER BY created_at DESC 
                LIMIT 1
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['max_xcount'])) {
            return $data[0]['max_xcount'];
        }
        header('location: /welcome');
        die();
    }



}
