<?php

session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$pollId = $_POST['id'];

// Query
setPollStatusOff($eventId);

// Query to update poll
$sql = 'UPDATE polls SET status=:status WHERE eventId =:eventid && pollId =:pollId;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':status' => 'live',
    ':eventid' => $eventId,
    ':pollId' => $pollId
);
if (!$stmt->execute($params)) {
    echo "queryProblem";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}
if (setLivePoll($eventId, $pollId)) {
    echo "success";
    exit();
} else {
    echo "queryProblem";
    exit();
}


