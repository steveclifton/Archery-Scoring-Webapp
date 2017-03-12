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
        $viewData['current_event'] = $setup->getCurrentEvent();
        $viewData['current_round'] = $setup->getCurrentRound();
        $viewData['db_name'] = $setup->getCurrentDB();
        $viewData['max_score'] = $setup->getCurrentMaxScore();
        $viewData['max_xcount'] = $setup->getCurrentMaxXCount();


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


    /**
     * Future - to be used to create an event
     */
    public function createEvent()
    {


        $this->render('Create Event', 'create_event.view');
    }

}
