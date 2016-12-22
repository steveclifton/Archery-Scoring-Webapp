<?php


namespace Archery;

require 'vendor/autoload.php';

use Archery\Controllers\Admin;
use Archery\Controllers\Authentication;
use Archery\Controllers\Profile;
use Archery\Controllers\Results;
use Archery\Controllers\Score;
use Archery\Controllers\User;
use Archery\Controllers\Welcome;
use Archery\Controllers\Errors;

session_start();

if (isset($_SERVER['REDIRECT_URL'])) {
    $uri = str_replace('/', '', $_SERVER['REDIRECT_URL']);
}

if ($uri == '') {
    header('location: /login');
    die();
}

else if ($uri == 'login') {
    $authentication = new Authentication();
    $authentication->login();
}

else if ($uri == 'welcome') {
    $accounts = new Welcome();
    $accounts->processWelcome();
}

else if ($uri == 'logout') {
    $authentication = new Authentication();
    $authentication->logout();
}

else if ($uri == 'register') {
    $authentication = new Authentication();
    $authentication->register();
}

else if ($uri == 'error') {
    $errorController = new Errors();
    $errorController->notFound();
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
else if ($uri == 'userprofileupdate') {
    $user = new Profile();
    $user->updateProfile();
}

else if ($uri == 'updateassociateduser') {
    $profile = new Profile();
    $profile->requestAccessToAssociate();
}

else if ($uri == 'rules') {
    $rules = new Welcome();
    $rules->displayRules();
}

else if ($uri == 'week') {
    $week = new Results();
    $week->viewScores();
}
else if ($uri == 'submitscore') {
    $week = new Results();
    $week->processScore();
}

else if ($uri == 'ajax_searchScoreWeekDiv') {
    $week = new Results();
    $week->ajaxSearchUserScoreWeekDiv();
}

else if ($uri == 'ajax_searchAnzArcher') {
    $user = new Results();
    $user->getUserByAnz();
}
else if ($uri == 'addtempuser') {
    $result = new Results();
    $result->addTempUser();
}
else {
    $errorController = new Errors();
    $errorController->notFound();
}


