<?php

namespace Archery\Configurations;


class Event
{
    private $currentEvent = 'Outdoor League Series';
    private $dbTableName = '30m_round';
    private $currentWeek = 10;

    public function getCurrentEventName()
    {
        return $this->currentEvent;
    }

    public function getTableName()
    {
        return $this->dbTableName;
    }

    public function getCurrentWeek()
    {
        return $this->currentWeek;
    }
}
