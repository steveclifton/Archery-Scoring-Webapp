<?php

namespace Archery\Controllers;


use Archery\Models\AdminConfig;
use Archery\Models\TempUser;
use Archery\Models\User;

class Admin extends Base
{

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


        $this->render('Admin', 'admin.view', $viewData);
    }

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

    public function confirmPendingAccounts()
    {
        $this->isAdminLoggedIn();

        $updatedUser = $_POST;
        $user = new User();

        $user->confirmPendingUsers($updatedUser);
        $this->adminView();
    }

}
