<?php


namespace Archery\Controllers;

use Archery\Models\Score;


class Results extends Base
{

    public function processScore()
    {
        $this->isNotLoggedIn();

        // check here to see if they have entered a score.
        // if they have , present them the score they have submited with the option 'Request Change'
        //



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $score = new Score();

            $score->liu_setScore($_POST['score'], $_POST['xcount']);

            //$score->getAllLoggedInUsersScores();

            print_r($_POST);
        }

        $this->render('Scoring', 'submitscore.view');


    }


}

