<?php
session_start();

// Include files
include '../database.inc.php';
// Declare Variables

$event_id = $_SESSION['event_id'];

// Sql Code
$sql = 'SELECT timestamp FROM polls WHERE eventId=:event_id;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':event_id' => $event_id
);
if (!$stmt->execute($params)) {
    // StmtFail
    echo 0;
    exit();
}
$count = $stmt->rowCount();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check count msgs
if ($count == 0) {
        $maxTimestamp = array('timestamp' => 0);
} else {
    $maxTimestamp = max($result);
}
if (isset($_SESSION['poll_timestamp_creator'])) {
    if ($_SESSION['poll_timestamp_creator'] == $maxTimestamp['timestamp']) {
        // Same to not print something else
        echo "same";
        exit();
    } else {
        // Diff to print the new msgs
        $_SESSION['poll_timestamp_creator'] = $maxTimestamp['timestamp'];
        echo "diff";
        exit();
    }
} else {
    $_SESSION['poll_timestamp_creator'] = $maxTimestamp['timestamp'];
    echo "diff";
    exit();
}
