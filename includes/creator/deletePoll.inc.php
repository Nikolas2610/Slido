<?php
include '../globalVariables.inc.php';
include_once '../database.inc.php';
// Declare Variables
$poll_id = $_POST['id'];

// Query
$sql = 'DELETE FROM polls WHERE pollId=:id;';
$stmt = $pdo->prepare($sql);
$param = array(
    ':id' => $poll_id
);
$stmt->bindParam(':id', $params[':id'], PDO::PARAM_INT);
if (!$stmt->execute($param)) {
    echo "Problem with query";
    header("location: " . $url . "polls.php?poll=list&error=stmtfail");
    exit();
} 
exit();