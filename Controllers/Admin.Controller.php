<?php

namespace Archery\Controllers;


use Archery\Models\TempUser;

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
        $pendingUsers = new TempUser();
        $users = $pendingUsers->getPendingUsers();

        if (is_array($users)) {
            return $users;
        } else {
            return false;
        }

    }

}