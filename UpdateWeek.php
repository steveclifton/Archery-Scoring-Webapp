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
// TODO
$currentWeek = $admin->getCurrentWeek(3);
$numWeeks = $admin->getNumWeeks(3);

$currentWeek = $currentWeek + 1;
if ($currentWeek == 16) {
    $currentWeek--;
}
$admin->setSetup(3, $currentWeek, $numWeeks);


// resets it back to the current week number for the below calculations
$currentWeek--;




/**
 * Issue points
 */

$eventNumber = 3; // this is the ID of the outdoor event


$handicap = new Handicap_Scores();

$results = $handicap->all_getHandicapForPoints($eventNumber, $currentWeek);

$score = new Score();
$points = new Points();


$pointValue = 10;
foreach ($results['compound'] as $archer) {
    $num = $score->countUsersScores($eventNumber, $archer['user_id'], 'compound');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($eventNumber, $archer['user_id'], $currentWeek, 'compound', $pointValue);
        $pointValue--;
    }
}

$pointValue = 10;
foreach ($results['recurve'] as $archer) {
    $num = $score->countUsersScores($eventNumber, $archer['user_id'], 'recurve');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($eventNumber, $archer['user_id'], $currentWeek, 'recurve', $pointValue);
        $pointValue--;
    }
}

$pointValue = 10;
foreach ($results['recurve barebow'] as $archer) {
    $num = $score->countUsersScores($eventNumber, $archer['user_id'], 'recurve barebow');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($eventNumber, $archer['user_id'], $currentWeek, 'recurve barebow', $pointValue);
        $pointValue--;
    }
}

$pointValue = 10;
foreach ($results['longbow'] as $archer) {
    $num = $score->countUsersScores($eventNumber, $archer['user_id'], 'longbow');
    if ($num > 1 && $pointValue > 0) {
        $points->setWeeklyPoints($eventNumber, $archer['user_id'], $currentWeek, 'longbow', $pointValue);
        $pointValue--;
    }
}

$result = $score->getAllDivisionArchers($eventNumber, 'compound');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($eventNumber, $r, 'compound');
    $points->setTotalPoints($eventNumber, $r, 'compound', $archerTotalPoints, $currentWeek);
}

$result = $score->getAllDivisionArchers($eventNumber, 'recurve');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($eventNumber, $r, 'recurve');
    $points->setTotalPoints($eventNumber, $r, 'recurve', $archerTotalPoints, $currentWeek);
}

$result = $score->getAllDivisionArchers($eventNumber, 'recurve barebow');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($eventNumber, $r, 'recurve barebow');
    $points->setTotalPoints($eventNumber, $r, 'recurve barebow', $archerTotalPoints, $currentWeek);
}

$result = $score->getAllDivisionArchers($eventNumber, 'longbow');
foreach ($result as $r) {
    $archerTotalPoints = $points->getArchersTotalPoints($eventNumber, $r, 'longbow');
    $points->setTotalPoints($eventNumber, $r, 'longbow', $archerTotalPoints, $currentWeek);
}

