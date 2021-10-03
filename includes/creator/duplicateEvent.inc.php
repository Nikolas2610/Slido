<?php
session_start();
// Include Files
include '../globalVariables.inc.php';
include '../functions.inc.php';
// Declare Variables
$username = $_SESSION['username'];
$event_id = $_POST['id'];
// Get event details
$event = getDetailsEvent($username, $event_id);
if ($event == 0) {
    echo 'stmtfailed';
    exit();
}
// Set the mode for create Event
$duplicateEvent = 1;
// For now
$invitePeople = 0;
// Duplicate Event and get the new publish id
$newEventId = createEvent($event['eventName'], $invitePeople, $event['startDate'], $event['endDate'], $username, $event['eventStatus'], $event['eventPassword'], $duplicateEvent, $event['reviewQa']);
if ($newEventId == 0) {
    echo 'stmtfailed';
    exit();
}
// Duplicate the polls of the previous event to the newone
$result = duplicatePolls($event_id, $newEventId);
// Check the function
if ($result == 1) {
    // Evetyrhing good
    echo 'duplicateEvent';
    exit();
} else {
    // Problem with the query
    echo 'stmtfailed';
    exit();
}
