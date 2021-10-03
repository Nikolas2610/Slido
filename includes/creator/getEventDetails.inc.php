<?php
include '../globalVariables.inc.php';

session_start();
// Save the eventId as SESSION VARIABLE
$_SESSION['event_id'] = $_POST['id'];
// Save the the page that goes as SESSION VARIABLE
$_SESSION['goes_to'] = $_POST['go'];




// Check if the event is private
include '../functions.inc.php';
include_once '../database.inc.php';
// Declare Variables
$username = $_SESSION['username'];
$event_id = $_SESSION['event_id'];
// Get details event
$event = getDetailsEvent($username, $event_id);

// Security check 
if ($event == 0) {
    echo 'queryProblem';
    exit();
} else {
    // Set session variable for the reviewQa
    $_SESSION['reviewQa'] = $event['reviewQa'];
    // Set session variable for the event status
    $_SESSION['event_status'] = $event['eventStatus'];
    // Set session variable for the event name
    $_SESSION['event_name'] = $event['eventName'];
    if ($event['eventStatus'] == 1) {
        echo 'privateEvent';
        exit();
    } else {
        echo 'puplicEvent';
        exit();
    }
}

