<?php

namespace Archery;

use Archery\Models\AdminConfig;
use Archery\Models\Handicap_Scores;
use Archery\Models\Points;
use Archery\Models\PointTotals;
use Archery\Models\Score;
use Dotenv\Dotenv;

require 'vendor/autoload.php';
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$admin = new AdminConfig();

/**
 * Increase the week by 1
 */

$currentWeek = $admin->getCurrentWeek();
$numWeeks = $admin->getNumWeeks();
$currentRound = $admin->getCurrentRound();
$currentEvent = $admin->getCurrentEvent();
$tableName = $admin->getCurrentDB();
$maxScore = $admin->getCurrentMaxScore();
$maxXcount = $admin->getCurrentMaxXCount();

$currentWeek = $currentWeek + 1;

//$admin->setSetup($currentWeek, $numWeeks, $currentRound, $currentEvent, $tableName, $maxScore, $maxXcount);
$currentWeek--;

/**
 * Issue points
 */

$handicap = new Handicap_Scores();

$results = $handicap->all_getHandicapForPoints($currentWeek);

$score = new Score();
$points = new Points();


$pointValue = 10;
foreach ($results['compound'] as $archer) {
    $num = $score->countUsersScores($archer['user_id'], 'compound');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($archer['user_id'], $currentWeek, 'compound', $pointValue);
        $pointValue--;
    }
}

$pointValue = 10;
foreach ($results['recurve'] as $archer) {
    $num = $score->countUsersScores($archer['user_id'], 'recurve');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($archer['user_id'], $currentWeek, 'recurve', $pointValue);
        $pointValue--;
    }
}

$pointValue = 10;
foreach ($results['recurve barebow'] as $archer) {
    $num = $score->countUsersScores($archer['user_id'], 'recurve barebow');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($archer['user_id'], $currentWeek, 'recurve barebow', $pointValue);
        $pointValue--;
    }
}

$pointValue = 10;
foreach ($results['longbow'] as $archer) {
    $num = $score->countUsersScores($archer['user_id'], 'longbow');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($archer['user_id'], $currentWeek, 'longbow', $pointValue);
        $pointValue--;
    }
}

$result = $score->getAllDivisionArchers('compound');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($r, 'compound');
    $points->setTotalPoints($r, 'compound', $archerTotalPoints);
}

$result = $score->getAllDivisionArchers('recurve');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($r, 'recurve');
    $points->setTotalPoints($r, 'recurve', $archerTotalPoints);
}

$result = $score->getAllDivisionArchers('recurve barebow');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($r, 'recurve barebow');
    $points->setTotalPoints($r, 'recurve barebow', $archerTotalPoints);
}

$result = $score->getAllDivisionArchers('longbow');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($r, 'longbow');
    $points->setTotalPoints($r, 'longbow', $archerTotalPoints);
}




// have a function that goes and gets all the points for a user
// updates the total points table
// creates an entry for the user

//
//   $archerTotalPoints = $points->getAllArchersPoints($archer['user_id'], 'compound');
//  $pointTotal->setPoints($archer['user_id'], $currentWeek, 'compound', $archerTotalPoints);
