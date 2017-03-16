<?php

namespace Archery\Controllers;


use Archery\Models\AdminConfig;
use Archery\Models\Contact_Messages;
use Archery\Models\User;

class Admin extends Base
{

    /**
     * Routes to Admin View
     */
    public function adminView()
    {
        $this->isAdminLoggedIn();

        $pendingUsers = $this->getPendingAccounts();
        $viewData['pending_users'] = $pendingUsers;

        $setup = new AdminConfig();
        $viewData['current_week'] = $setup->getCurrentWeek();
        $viewData['num_weeks'] = $setup->getNumWeeks();

        $this->render('Admin', 'admin.view', $viewData);
    }


    /**
     * Returns the users that are pending
     */
    private function getPendingAccounts()
    {
        $pendingUsers = new User();
        $users = $pendingUsers->getPendingUsers();

        if (is_array($users)) {
            return $users;
        } else {
            return false;
        }
    }

    /**
     * Confirms a user
     */
    public function confirmPendingAccounts()
    {
        $this->isAdminLoggedIn();

        $updatedUser = $_POST;

        $user = new User();

        $user->confirmPendingUsers($updatedUser);
        $this->adminView();
    }


    /*
     * Sets the event setup
     */
    public function setSetup()
    {
        $admin = new AdminConfig();

        $currentWeek = $_POST['currentweek'];
        $numWeeks = $_POST['numweeks'];

        // TODO get the event number here

        $admin->setSetup(2, $currentWeek, $numWeeks);

        $_SESSION['current_week'] = $currentWeek;
        header('location: /admin');
        die();
    }

    /*
     * Returns the number of weeks
     */
    public function getCurrentWeek()
    {
        $admin = new AdminConfig();

        return $admin->getCurrentWeek();
    }


    /**
     * Future - to be used to create an event
     */
    public function createEvent()
    {


        $this->render('Create Event', 'create_event.view');
    }


}
