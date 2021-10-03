<?php

session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$pollId = $_POST['id'];

// Query
$sql = 'UPDATE polls SET status=:status WHERE eventId =:eventid && pollId =:pollId;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':status' => 'off',
    ':eventid' => $eventId,
    ':pollId' => $pollId
);
if (!$stmt->execute($params)) {
    echo "queryProblem";
    exit();
} 



// Query
$sql = 'UPDATE livepolls SET pollId=:pollId WHERE eventId =:eventid;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':pollId' => -1
);
if (!$stmt->execute($params)) {
    echo "queryProblem";
    exit();
}
$counts = $stmt->rowCount();
if ($counts == 0) {
    $sql = 'INSERT INTO livepolls (eventid, pollId) 
    VALUES (:eventid, :pollId);';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':eventid' => $eventId,
        ':pollId' => -1
    );
    if (!$stmt->execute($params)) {
        echo "queryProblem";
        exit();
    }
}
echo 'success';