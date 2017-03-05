<?php

namespace Archery\Controllers;


use Archery\Models\AdminConfig;
use Archery\Models\Contact_Messages;
use Archery\Models\User;

class Admin extends Base
{

    public function contact()
    {
        $this->render('Contact', 'contact.view');
    }

    public function ajax_contactForm()
    {
        $name = strtolower(trim($_POST['name']));
        $email = strtolower(trim($_POST['email']));
        $message = strtolower(trim($_POST['message']));

        $contact = new Contact_Messages();
        $result = $contact->setMessage($name, $email, $message);

        if ($result) {
            echo json_encode(array('status' => 'passed', 'message' => 'Message Sent'));
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Please try again later'));
        }


    }

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

    public function createEvent()
    {


        $this->render('Create Event', 'create_event.view');
    }

}
