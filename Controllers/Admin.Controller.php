<?php

namespace Archery\Controllers;


use Archery\Models\AdminConfig;
use Archery\Models\Contact_Messages;
use Archery\Models\Events;
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
        $events = new Events();

        $viewData['users'] = $setup->getCurrentUsers();
        $viewData['events'] = $events->getAllEvents();

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

        $currentWeek = $_POST['currentEventWeek'];
        $numWeeks = $_POST['currentEventNumWeeks'];

        // TODO
        $admin->setSetup(3, $currentWeek, $numWeeks);

        $_SESSION['current_week'] = $currentWeek;
        header('location: /admin');
        die();
    }

    public function ajax_getEventDetails()
    {
        echo json_encode(array("status" => "success")); return;

        $eventId = $_POST['id'];

        $admin = new AdminConfig();

        $setup = $admin->getCurrentSetup($eventId);

        $numWeeks = $setup['number_weeks'];
        $currentWeek = $setup['current_week'];

        echo json_encode(array("status" => "success", "currentWeek" => $currentWeek, "numWeeks" => $numWeeks));
        return;

    }

    /*
     * Returns the number of weeks
     */
    public function getCurrentWeek($event)
    {
        $admin = new AdminConfig();

        return $admin->getCurrentWeek($event);
    }


    /**
     * Future - to be used to create an event
     */
    public function createEvent()
    {
        $this->render('Create Event', 'create_event.view');
    }


}
