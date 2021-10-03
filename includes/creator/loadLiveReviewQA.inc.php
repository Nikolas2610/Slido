<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];


// Query
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid && status=:status ORDER BY dateCreate DESC;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':status' => 0
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();
if (isset($_SESSION['msgs_reviewQa'])) {
    if ($_SESSION['msgs_reviewQa'] != $count) {
        echo 'diff';
    } else {
        echo 'same';
    }
} else {
    $_SESSION['msgs_reviewQa'] = $count;
}