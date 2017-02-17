<?php

namespace Archery;

use Archery\Models\AdminConfig;
use Dotenv\Dotenv;

require 'vendor/autoload.php';
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$admin = new AdminConfig();

$currentWeek = $admin->getCurrentWeek();
$numWeeks = $admin->getNumWeeks();
$currentRound = $admin->getCurrentRound();
$currentEvent = $admin->getCurrentEvent();
$tableName = $admin->getCurrentDB();
$maxScore = $admin->getCurrentMaxScore();
$maxXcount = $admin->getCurrentMaxXCount();

$currentWeek = $currentWeek + 1;

$admin->setSetup($currentWeek, $numWeeks, $currentRound, $currentEvent, $tableName, $maxScore, $maxXcount);
