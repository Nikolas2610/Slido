<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
include '../globalVariables.inc.php';
// Declare Variables
$eventId = $_SESSION['guest_event_id'];
if (!isset($_SESSION['poll_id'])) {
    $_SESSION['poll_id'] = -1;
}
// echo 'SESSION: ' . $_SESSION['poll_id'] . "______";
$pollId = $_SESSION['poll_id'];

// Query
$sql = 'SELECT * FROM livepolls WHERE eventId=:eventid LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
$stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
if (!$stmt->execute()) {
    echo "Problem with query";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result['pollId'] == $pollId) {
    if ($result['pollId'] > 0) {
        echo "activeSame";
    }
    if ($result['pollId'] < 0) {
        echo "notActiveSame";
    }
} else {
    if ($result['pollId'] == -1) {
        // echo "Not active";
        $_SESSION['poll_id'] = -1;
        echo "notActive";
    }
    if ($result['pollId'] > 0) {
        // echo "New Poll";
        $_SESSION['poll_id'] = $result['pollId'];
        $_SESSION['guest_poll_answer'] = 0;
        echo "newPoll";
    }
}
exit();
