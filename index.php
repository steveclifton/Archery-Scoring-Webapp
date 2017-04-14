<?php


namespace Archery;

require 'vendor/autoload.php';

use Archery\Controllers\Competition;
use Dotenv\Dotenv;
use Archery\Controllers\Contact;
use Archery\Controllers\Admin;
use Archery\Controllers\Authentication;
use Archery\Controllers\Profile;
use Archery\Controllers\Results;
use Archery\Controllers\Welcome;

session_start();

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

//$web = explode('/', $_SERVER['REDIRECT_URL']);

//if ($web[1] == 'indoorleague') {
//    if ($web[2] == '2017') {
//        $week = new Results();
//        $week->viewScores('2017 Indoor League Series');
//    }
//}
//
//
//else if ($web[1] == 'outdoorleague') {
//    if ($web[2] == '2017') {
//        $week = new Results();
//        $week->viewScores('2017 Outdoor League Series');
//    }
//}



if (isset($_SERVER['REDIRECT_URL'])) {
    $uri = str_replace('/', '', $_SERVER['REDIRECT_URL']);
} else if (isset($_SERVER['REQUEST_URI'])) {
    $uri = str_replace('/', '', $_SERVER['REQUEST_URI']);
}

if ($uri == '') {
    $week = new Admin();
    $weekNum = $week->getCurrentWeek(3);
    header("Location: /week?week=$weekNum");
    die();
    $welcome = new Welcome();
    $welcome->welcome();
}

else if ($uri == 'ajaxCheckLogin') {
    $auth = new Authentication();
    $auth->ajaxCheckLogin();
}

else if ($uri == 'myscores') {
    $accounts = new Welcome();
    $accounts->processWelcome();
}

else if ($uri == 'overall') {
    $result = new Results();
    $result->viewOverallScores();
}

else if ($uri == 'logout') {
    $authentication = new Authentication();
    $authentication->logout();
}

else if ($uri == 'register') {
    $authentication = new Authentication();
    $authentication->register();
}

else if ($uri == 'updatesetup') {
    $admin = new Admin();
    $admin->setSetup();
}

else if ($uri == 'admin') {
    $admin = new Admin();
    $admin->adminView();
}
else if ($uri == 'confirmusers') {
    $admin = new Admin();
    $admin->confirmPendingAccounts();
}
else if ($uri == 'userprofile') {
    $user = new Profile();
    $user->viewProfile();
}

else if ($uri == 'ajaxUpdateProfile') {
    $user = new Profile();
    $user->ajaxUpdateProfile();
}

else if ($uri == 'ajax_viewOverall') {
    $result = new Results();
    $result->ajax_viewOverall();
}

else if ($uri == 'ajax_getEventDetails') {
    $admin = new Admin;
    $admin->ajax_getEventDetails();
}

else if ($uri == 'updateassociateduser') {
    $profile = new Profile();
    $profile->updateAssociation();
}

else if ($uri == 'competitions') {
    $comp = new Competition();
    $comp->getCompetitions();
}

else if ($uri == 'rules') {
    $rules = new Welcome();
    $rules->displayRules();
}

else if ($uri == 'week') {
    $week = new Results();
    $week->viewScores();
}
else if ($uri == 'ajax_submitScore') {
    $week = new Results();
    $week->ajax_processScore();
}

else if ($uri == 'ajax_searchScoreWeekDiv') {
    $week = new Results();
    $week->ajaxSearchUserScoreWeekDiv();
}

else if ($uri == 'ajax_createaccount') {
    $auth = new Authentication();
    $auth->ajaxRegisterAccount();
}
else if ($uri == 'ajax_createprofile') {
    $auth = new Authentication();
    $auth->ajaxRegisterProfile();
}

else if ($uri == 'ajax_searchAnzArcher') {
    $user = new Results();
    $user->getUserByAnz();
}
else if ($uri == 'ajax_addTempUser') {
    $result = new Results();
    $result->ajax_addTempUser();
}
else if ($uri == 'resetpassword') {
    var_dump($_GET);die();
}

else if ($uri == 'create_event') {
    $admin = new Admin();
    $admin->createEvent();
}

else if ($uri == 'contact') {
    $admin = new Contact();
    $admin->contact();
}

else if ($uri == 'ajax_submitContact') {
    $admin = new Contact();
    $admin->ajax_contactForm();
}

else {
    header('location: /');
    die();
}


