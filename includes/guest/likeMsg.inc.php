<?php
// Include database connection
require '../database.inc.php';
require '../functions.inc.php';
session_start();
// Set variables
$msg_id = $_POST['id'];
$likes = $_POST['likes'] + 1;
$event_id = $_SESSION['guest_event_id'];
$user_id = $_SESSION['userId'];
// if (isset($_SESSION['username'])) {
//     $user_id = $_SESSION['userId'];
// } else {
//     $user_id = $_SESSION['userId'];
//     echo $_SESSION['userId'];
//     exit();
// }


// Query to get the likes msgs of the user
$sql = 'SELECT * FROM guests WHERE eventId=:eventid && usersId=:userid LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $event_id,
    ':userid' => $user_id
);
if (!$stmt->execute($params)) {
    // Query error
    echo "0";
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($result['likeMsgs'])) {
    $newMsgLikes = $msg_id;
} else {
    $newMsgLikes = $result['likeMsgs'] . '/ ' . $msg_id;
}


// Query to save the new like to the guest table
$sql = "UPDATE guests SET likeMsgs=:msgId 
            WHERE usersId=:id && eventId=:eventid;";
$stmt = $pdo->prepare($sql);
$params = array(
    ':msgId' => $newMsgLikes,
    ':id' => $user_id,
    ':eventid' => $event_id,
);
// Check query
if (!$stmt->execute($params)) {
    // Problem with query
    echo 0;
    exit();
}

// Query to the likes of the msgs
$sql = "UPDATE msgs SET likes=:likes 
            WHERE msgId=:id;";
$stmt = $pdo->prepare($sql);
$params = array(
    ':likes' => $likes,
    ':id' => $msg_id
);
// Check query
if (!$stmt->execute($params)) {
    // Problem with query
    echo 0;
    exit();
}

// Everything Good
echo "1";
exit();
