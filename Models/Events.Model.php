<?php


namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Events extends Base
{

    /**
     * Returns all the events in the system
     */
    public function getAllEvents()
    {
        $sql = "SELECT id, name, start_date, end_date, round
                FROM `events` 
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$eventName'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;

    }


    /**
     * Returns the Event ID number
     */
    public function getEventId($eventName)
    {
        $sql = "SELECT id 
                FROM `events` 
                WHERE `events`.`name` = '$eventName'
                ";

        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$eventName'));

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data[0]['id'])) {
            return $data[0]['id'];
        } else {
            return -1;
        }

    }

    public function setEvent()
    {
        $sql = "INSERT INTO `events` (`id`, `name`, `start_date`, `end_date`, `round`, `created_at`) 
                VALUES (NULL, '2017 Outdoor League Series', NULL, NULL, '2', '21:47:09 15-02-2017')
                ";

    }
}