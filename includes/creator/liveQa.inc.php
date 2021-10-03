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
$sql = 'SELECT timestamp,status FROM msgs WHERE eventId=:event_id && status=:status1 || status=:status2;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':event_id' => $event_id,
    ':status1' => 1,
    ':status2' => 2
);
if (!$stmt->execute($params)) {
    // StmtFail
    echo 'queryProblem';
    exit();
}
$count = $stmt->rowCount();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Check count msgs
if ($count == 0) {
    $maxTimestamp = array(
        'timestamp' => 0
    );
    if (isset($_SESSION['countQa'])) {
        if ($_SESSION['countQa'] != $count) {
            // Check if delete questions
            $_SESSION['countQa'] = $count;
            echo "diff";
            exit();
        } else {
            echo "same";
            exit();
        }
    } else {
        $_SESSION['countQa'] = $count;
        echo "same";
        exit();
    }
} else {
    // Get the new msg 
    $maxTimestamp = max($result);

    if (isset($_SESSION['countQa'])) {
        if ($count != $_SESSION['countQa']) {
            $_SESSION['countQa'] = $count;
            $_SESSION['timestamp'] = $maxTimestamp['timestamp'];
            echo "diff";
            exit();
        }   
    } else {
        $_SESSION['countQa'] = $count;
    }
}

if (isset($_SESSION['timestamp'])) {
    if ($_SESSION['timestamp'] == $maxTimestamp['timestamp']) {
        // Same to not print something else
        echo "same";
        exit();
    } else {
        // Diff to print the new msgs
        $_SESSION['timestamp'] = $maxTimestamp['timestamp'];
        echo "diff";
        exit();
    }
} else {
    $_SESSION['timestamp'] = $maxTimestamp['timestamp'];
    echo "diff";
    exit();
}
