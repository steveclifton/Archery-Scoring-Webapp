<?php

namespace Archery\Controllers;


use Archery\Models\TempUser;
use Archery\Models\User;

class Admin extends Base
{

    public function adminView()
    {
        $this->isAdminLoggedIn();

        $pendingUsers = $this->getPendingAccounts();

        $viewData['pending_users'] = $pendingUsers;

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
        $updatedUser = $_POST;
        $user = new User();

        $user->confirmPendingUsers($updatedUser);
        $this->adminView();
    }

}
