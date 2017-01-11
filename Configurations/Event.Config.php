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

    private $currentEvent = 'Outdoor League Series';
    private $dbTableName = '30m_round';
    private $currentWeek = 10;
    private $numberOfWeeks = 15;

    public function setSetup()
    {
        $this->setup->getCurrentWeek();

        $currentWeek = $_POST['currentweek'];
        $numWeeks=$_POST['numweeks'];
        $currentRound =$_POST['currentround'];
        $currentEvent=$_POST['currentevent'];
        $tableName=$_POST['tablename'];

        $this->setup->setSetup($currentWeek, $numWeeks, $currentRound, $currentEvent, $tableName);

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

