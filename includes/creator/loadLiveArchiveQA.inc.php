<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$repliesIds = array();

// Query
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid && status=:status ORDER BY dateCreate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':status' => -1
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();
if (isset($_SESSION['msgs_archiveQa'])) {
    if ($_SESSION['msgs_archiveQa'] != $count) {
        echo 'diff';
    } else {
        echo 'same';
    }
} else {
    $_SESSION['msgs_archiveQa'] = $count;
}