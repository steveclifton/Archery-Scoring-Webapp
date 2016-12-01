<?php


namespace Archery\Controllers;

use Archery\Models\Score;


class Results extends Base
{

    public function viewScores()
    {
        $this->isNotLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $score = new Score();

            $viewData = $score->all_getCWScores($_GET['week']);

            foreach ($viewData as $data) {
                if ($data['user_id'] == $_SESSION['id']) {
                    $userResults = $data;
                    $this->renderScores('Scoring', 'week.view', $viewData, $userResults);
                }
            }
        }


        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $score = new Score();

            $score->liu_setScore($_POST['score'], $_POST['xcount'], $_POST['week']);

            //$score->getAllLoggedInUsersScores();

            print_r($_POST);
        }

        $this->render('Scoring', 'week.view', $viewData);


    }


}

