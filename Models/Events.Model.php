<?php


namespace Archery\Models;

use Archery\Configurations\Event;
use PDO;

class Events extends Base
{
    public function getEvent($eventName)
    {
        $sql = "SELECT * FROM `events` WHERE `events`.`name` = '$eventName'
                ";


        $stm = $this->database->prepare(($sql), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stm->execute(array('$eventName'));

        $data = $stm->fetchAll();

        return $data;
    }

    public function setEvent()
    {
        $sql = "INSERT INTO `events` (`id`, `name`, `start_date`, `end_date`, `round`, `created_at`) 
                VALUES (NULL, '2017 Outdoor League Series', NULL, NULL, '2', '21:47:09 15-02-2017')
                ";

    }
}