<?php
session_start();
// Include database fot the query
include_once '../database.inc.php';
// Declare Variables
$event_id = $_POST['id'];
$username = $_SESSION['username'];

// Query to delete event
$sql = 'DELETE FROM events WHERE publishId=:id && creator=:username;';
$stmt = $pdo->prepare($sql);
$param = array(
    ':id' => $event_id,
    ':username' => $username
);
if (!$stmt->execute($param)) {
    echo "queryProblem";
    exit();
} 

// Query to delete the polls of the event 
$sql = 'DELETE FROM polls WHERE eventId=:id;';
$stmt = $pdo->prepare($sql);
$param = array(
    ':id' => $event_id
);
if (!$stmt->execute($param)) {
    echo "queryProblem";
    exit();
} 

// Query to delete the polls of the event 
$sql = 'DELETE FROM msgs WHERE eventId=:id;';
$stmt = $pdo->prepare($sql);
$param = array(
    ':id' => $event_id
);
if (!$stmt->execute($param)) {
    echo "queryProblem";
    exit();
} 
echo 'deleteEvent';
exit();
