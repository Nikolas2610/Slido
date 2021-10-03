<?php

session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$pollId = $_POST['id'];
$value = $_POST['value'];
if ($value == '0') {
    $newValue = '1';
} else {
    $newValue = '0';
}


// Query
$sql = 'UPDATE polls SET showAnswers=:status WHERE eventId =:eventid && pollId =:pollId LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':status' => $newValue,
    ':eventid' => $eventId,
    ':pollId' => $pollId
);
if (!$stmt->execute($params)) {
    echo "Problem with query";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}

