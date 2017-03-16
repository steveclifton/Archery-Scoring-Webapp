<?php

namespace Archery\Controllers;

class Competition extends Base
{
    public function getCompetitions()
    {
        $this->render('Competitions', 'competitions.view');
    }
}