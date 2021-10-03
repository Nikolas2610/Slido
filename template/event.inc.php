<?php
include '../globalVariables.inc.php';

session_start();
// Save the eventId as SESSION VARIABLE
$_SESSION['event_id'] = $_GET['room'];
$_SESSION['event_name'] = $_GET['eventname'];

// Check if the event is private
include '../functions.inc.php';
include_once '../database.inc.php';
// Declare Variables
$username = $_SESSION['username'];
$event_id = $_SESSION['event_id'];

$event = getDetailsEvent($username, $event_id);

// Security check 
if ($event == 0) {
    header("location: " . $url . "index.php");
} else {
    // Set session variable for the reviewQa
    $_SESSION['reviewQa'] = $event['reviewQa'];
    // Set session variable for the event status
    $_SESSION['event_status'] = $event['eventStatus'];
    
    if ($_SESSION['event_status'] == 1) {
        if (!isset($_SESSION['pwd_match'])) {
            header("location: " . $url . "needPassword.php?for=join");
            exit();
        } elseif ($_SESSION['pwd_match'] == 0) {
            header("location: " . $url . "needPassword.php?for=join");
            exit();
        }
    }
    header("location: " . $url . "polls.php?poll=list");
}
exit();
