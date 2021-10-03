<?php
include '../globalVariables.inc.php';
include_once '../database.inc.php';
// Declare Variables
$msg_id = $_POST['id'];
$nextMsg = 0;
while ($nextMsg != -1) {
    // Query to get the next msg
    $sql = 'SELECT * FROM msgs WHERE msgId=:id;';
    $stmt = $pdo->prepare($sql);
    $param = array(
        ':id' => $msg_id
    );
    if (!$stmt->execute($param)) {
        // Problem with the query
        echo 'queryProblem';
        exit();
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nextMsg = $result['reply'];

    // Query to delete message
    $sql = 'DELETE FROM msgs WHERE msgId=:id;';
    $stmt = $pdo->prepare($sql);
    $param = array(
        ':id' => $msg_id
    );
    if (!$stmt->execute($param)) {
        // Problem with the query
        echo 'queryProblem';
        exit();
    }
    $msg_id = $nextMsg;
}

// Everything Good
echo 'decline';
exit();
