<?php
// Include database connection
require '../database.inc.php';
session_start();
// Set variables
$msg_id = $_POST['id'];
$highlight = $_POST['valueHighlight'];
$event_id = $_SESSION['event_id'];

// Query to set all msg to no highlights. Beacause one highligh per event
$sql = "UPDATE msgs SET highlight=:zero 
            WHERE eventId=:event_id;";
$stmt = $pdo->prepare($sql);
$params = array(
    ':zero' => 0,
    ':event_id' => $event_id
);
// Check query
if (!$stmt->execute($params)) {
    // Problem with query
    echo 'queryProblem';
    exit();
}


// Query to update the username
$sql = "UPDATE msgs SET highlight=:highlight 
            WHERE msgId=:id;";
$stmt = $pdo->prepare($sql);
$params = array(
    ':highlight' => $highlight,
    ':id' => $msg_id
);
// Check query
if (!$stmt->execute($params)) {
    // Problem with query
    echo 'queryProblem';
    exit();
}


// Everything Good
echo "highlight";
exit();
