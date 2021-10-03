<?php

if (isset($_POST['saveChanges'])) {
    session_start();
    require_once '../functions.inc.php';
    $eventid = $_SESSION['event_id'];
    $eventname = $_POST['eventName'];
    $invitePeople = $_POST['invitePeople'];
    $startDate = changeTimeDashForSql($_POST['startDate']);
    $endDate = changeTimeDashForSql($_POST['endDate']);
    $username =  $_SESSION['username'];


    // Check box for the review QA
    if (isset($_POST['reviewQa'])) {
        $reviewQa = 1;
    } else {
        $reviewQa =0;
    }


    // Check if room is private or puplic
    if (isset($_POST['privateEvent'])) {
        // Private Room
        $privateRoom = 1;
        // If password field get the password from session value
        if (isset($_POST['eventPassword'])) {
            $roomPassword = $_POST['eventPassword'];
            $roomConfirmPassword = $_POST['eventConfirmPassword'];
            // Check if the password and confirm password are match
            if (passwordsMatch($roomPassword, $roomConfirmPassword)) {
                header("location: ../events.php?error=diffpasswords");
                exit();
            }
        } else {
            $roomPassword =  $_SESSION['pwd'];
        }
        unset($_SESSION['pwd']);
    } else {
        // Puplic Room
        $privateRoom = 0;
        $roomPassword = -1;
    }
// Check event name
    if (empty($eventname)) {
        header("location: ../events.php?error=emptyEventName");
        exit();
    }
    // Check start date
    if (empty($startDate)) {
        header("location: ../events.php?error=emptyStartDate");
        exit();
    }
    // Check End date
    if (empty($endDate)) {
        header("location: ../events.php?error=emptyEndDate");
        exit();
    }

    updateEvent($eventid, $eventname, $invitePeople, $startDate, $endDate, $username, $privateRoom, $roomPassword, $reviewQa);
}
