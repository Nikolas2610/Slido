<?php
session_start();
include '../globalVariables.inc.php';
include_once '../database.inc.php';
// Declare Variables
$user_id = $_SESSION['userId'];
$msg_id = $_POST['id'];
$nextMsg = 0;
$rowsDelete = 0;
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
    $senderId = $result['usersId'];
    if ($senderId == $user_id) {
        $nextMsg = -1;
        $previousMsgId = $result['msgId'];
        $nextMsgId = $result['reply'];
    } else {
        $nextMsg = $result['reply'];
        $rowsDelete++;
        $user_id = 0;
    }

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

    if ($nextMsg == -1 && $rowsDelete == 0) {
        $sql = 'SELECT msgId FROM msgs WHERE reply=:id;';
        $stmt = $pdo->prepare($sql);
        $param = array(
            ':id' => $previousMsgId
        );
        if (!$stmt->execute($param)) {
            // Problem with the query
            echo 'queryProblem';
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $updateMsgId = $result['msgId'];

        $sql = "UPDATE msgs SET reply=:reply_next_id WHERE msgId=:msg_id;";
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':reply_next_id' => $nextMsgId,
            ':msg_id' => $updateMsgId
        );
        if (!$stmt->execute($params)) {
            // Query Problem
            echo 'queryProblem';
            exit();
        }
    }
    $msg_id = $nextMsg;
}

// Everything Good
echo 'delete';
exit();
