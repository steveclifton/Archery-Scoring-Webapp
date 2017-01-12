<?php


namespace Archery\Controllers;


class Welcome extends Base
{

    public function displayRules()
    {
        $this->render('Rules', 'rules.view');
    }

}

