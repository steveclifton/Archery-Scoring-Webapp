<?php

namespace Archery\Configurations;


use Archery\Models\AdminConfig;

class Event
{
    private $setup;

    function __construct()
    {
        $this->setup = new AdminConfig();
    }

    public function setSetup()
    {
        $this->setup->getCurrentWeek();

        $currentWeek = $_POST['currentweek'];
        $numWeeks=$_POST['numweeks'];
        $currentRound =$_POST['currentround'];
        $currentEvent=$_POST['currentevent'];
        $tableName=$_POST['tablename'];
        $maxScore = $_POST['maxscore'];
        $maxxCount = $_POST['maxxcount'];

        $this->setup->setSetup($currentWeek, $numWeeks, $currentRound, $currentEvent, $tableName, $maxScore, $maxxCount);

        header('location: /admin');
        die();
    }

    public function getCurrentEventName()
    {
        return $this->setup->getCurrentEvent();
    }

    public function getTableName()
    {
        return $this->setup->getCurrentDB();
    }

    public function getCurrentWeek()
    {
        return $this->setup->getCurrentWeek();
    }

    public function getNumberOfWeeks()
    {
        return $this->setup->getNumWeeks();
    }


}

