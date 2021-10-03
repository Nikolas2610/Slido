<?php 
session_start();
include '../database.inc.php';
$event_id = $_SESSION['guest_event_id'];
if (!isset($_SESSION['poll_id'])) {
    $_SESSION['poll_id'] = -1;
}
$previous_poll_id = $_SESSION['poll_id'];
// Query to get the likes msgs of the user
$sql = 'SELECT * FROM events WHERE publishId=:eventid LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $event_id
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();
// echo $count;
if ($count == 0) {
    echo "eventNotExists";
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$reviewQa = $result['reviewQa'];
if ($reviewQa != $_SESSION['reviewQa']) {
    $_SESSION['reviewQa'] = $reviewQa;
}

// Query to get the live poll
$sql = 'SELECT * FROM livepolls WHERE eventId=:eventid LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $event_id
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();
if ($count == 0) {
    echo "notActive";
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$new_poll_id = $result['pollId'];
if ($new_poll_id == $previous_poll_id) {
    if ($new_poll_id > 0) {
        echo "activeSame";
    }
    if ($new_poll_id < 0) {
        echo "notActiveSame";
    }
} else {
    if ($new_poll_id == -1) {
        // echo "Not active";
        $_SESSION['poll_id'] = -1;
        echo "notActive";
    }
    if ($new_poll_id > 0) {
        // echo "New Poll";
        $_SESSION['poll_id'] = $new_poll_id;
        $_SESSION['guest_poll_answer'] = 0;
        echo "newPoll";
    }
}
exit();

