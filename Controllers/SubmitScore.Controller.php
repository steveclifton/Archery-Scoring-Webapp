<?php


namespace Archery\Controllers;

use Archery\Configurations\Event;
use Archery\Models\Events;
use Archery\Models\Scores;


class SubmitScore extends Base
{


    public function submitScores($eventName, $userId, $division, $scoreData)
    {
        $event = new Event();
        $eventRound = $this->getEventRound($eventName);

        $score1Data = $this->processScoreData($scoreData[0]);
        $score2Data = $this->processScoreData($scoreData[1]);
        $score3Data = $this->processScoreData($scoreData[2]);
        $score4Data = $this->processScoreData($scoreData[3]);

        $totalData = $this->processTotalData($score1Data, $score2Data, $score3Data, $score4Data);

        $newScores = new Scores();
        $newScores->setScore($eventName, $eventRound, $userId, $division, $score1Data, $score2Data, $score3Data, $score4Data, $totalData);
    }

    private function getEventRound($eventName)
    {
        $event = new Events();
        $eventData = $event->getEvent($eventName);

        return $eventRound = $eventData['event_round'];
    }


    /**
     * Loops through the scores provided 16x
     *  - Those scores that are not set are
     */
    private function processScoreData($scoreData)
    {
        $returnData = array();
        for ($i = 0; $i < 4; $i++) {
            if (!isset($scoreData[$i])) {
                $returnData[$i] = NULL;
            } else {
                $returnData[$i] = $scoreData[$i];
            }
        }

        return $returnData;
    }

    private function processTotalData($score1, $score2, $score3, $score4)
    {
        $totalData = array();

        $totalData[0] = $this->processTotals($score1[0], $score2[0], $score3[0], $score4[0]);
        $totalData[1] = $this->processTotals($score1[1], $score2[1], $score3[1], $score4[1]);
        $totalData[2] = $this->processTotals($score1[2], $score2[2], $score3[2], $score4[2]);
        $totalData[3] = $this->processTotals($score1[3], $score2[3], $score3[3], $score4[4]);

        return $totalData;
    }



    private function processTotals($score1, $score2, $score3, $score4)
    {
        $total = 0;

        if ($score1 != NULL) {
            $total += $score1;
        }
        if ($score2 != NULL) {
            $total += $score2;
        }
        if ($score3 != NULL) {
            $total += $score3;
        }
        if ($score4 != NULL) {
            $total += $score4;
        }

        return $total;


    }
}