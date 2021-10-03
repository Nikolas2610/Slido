<?php
// Include database connection
require '../database.inc.php';

// Set variables
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
    $sql = "UPDATE msgs SET status=:status WHERE msgId=:id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':status' => 1,
        ':id' => $msg_id
    );
    // Check query
    if (!$stmt->execute($params)) {
        // Problem with query
        echo 'queryProblem';
        exit();
    }
    $msg_id = $nextMsg;
}

// Everything Good
echo "accept";
exit();

