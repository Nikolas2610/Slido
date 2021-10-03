<?php
include 'globalVariables.inc.php';

if (isset($_POST['createEvent'])) {
    session_start();
    require_once 'functions.inc.php';

    // Set variavles
    $duplicateEvent = 0;
    $eventname =  $_POST['eventName'];
    $invitePeople = $_POST['invitePeople'];
    $startDate = changeTimeDashForSql($_POST['startDate']);
    $endDate = changeTimeDashForSql($_POST['endDate']);
    $userid = $_SESSION['userId'];
    $username =  $_SESSION['username'];

    // Check if event name is empty
    if (empty($eventname)) {
        header("location: ../events.php?error=emptyEventName");
        exit();
    }
    // Check if event name is empty
    if (empty($_POST['startDate'])) {
        header("location: ../events.php?error=emptyStartDate");
        exit();
    }
    // Check if event name is empty
    if (empty($_POST['endDate'])) {
        header("location: ../events.php?error=emptyEndDate");
        exit();
    }

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
        $roomPassword = $_POST['eventPassword'];
        $roomConfirmPassword = $_POST['eventConfirmPassword'];
        if (passwordsMatch($roomPassword, $roomConfirmPassword)) {
            header("location: ../events.php?error=diffPasswords");
            exit();
        }
    } else {
        // Puplic Room
        $privateRoom = 0;
        $roomPassword = -1;
    }

    $result = createEvent($eventname, $invitePeople, $startDate, $endDate, $username, $privateRoom, $roomPassword, $duplicateEvent, $reviewQa);
    if ($result == 0) {
        header("location: " . $url . "events.php?error=stmtfailed");
    } else {
        header("location: " . $url . "events.php?success=createEvent");
    }
} else {
    // If not set back to events.php
    header("location: ../events.php");
    exit();
};
