<?php
session_start();

// Include files
include '../database.inc.php';
// Declare Variables
if (isset($_SESSION['event_id'])) {
    $event_id = $_SESSION['event_id'];
} else {
    $event_id = $_SESSION['guest_event_id'];
}

// Sql Code
$sql = 'SELECT * FROM msgs WHERE eventId=:event_id && status=:status;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':event_id' => $event_id,
    ':status' => 0
);
if (!$stmt->execute($params)) {
    // StmtFail
    echo 'queryproblem';
    exit();
}
$count = $stmt->rowCount();
$_SESSION['count_notifications_Qa']=$count;
echo $count;

