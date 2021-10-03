<?php

include '../database.inc.php';
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

    // Query to update the username
    $sql = "UPDATE msgs SET status=:status WHERE msgId=:msg_id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':msg_id' => $msg_id,
        ':status' => -1
    );
    if (!$stmt->execute($params)) {
        // Query Problem
        echo 'queryProblem';
        exit();
    }
    $msg_id = $nextMsg;
}


// Everything Ok
echo 'archive';
exit();
