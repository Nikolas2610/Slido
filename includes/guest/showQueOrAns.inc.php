<?php
session_start();
include '../database.inc.php';
// Declare Variables
if (isset($_SESSION['poll_id'])) {
    $poll_id =  $_SESSION['poll_id'];
} else {
    $poll_id = -1;
}
$event_id =  $_SESSION['guest_event_id'];
$user_id =  $_SESSION['userId'];

// Query
$sql = 'SELECT * FROM guests WHERE usersId=:user_id && eventId=:event_id LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':user_id' => $user_id,
    ':event_id' => $event_id,
);
if (!$stmt->execute($params)) {
    // Problem with query
    echo 'queryProblem';
    exit();
}
$result = $stmt->fetch();
$answersArray = explode('/', $result->answers);

for ($i=0; $i < sizeof($answersArray) ; $i++) { 
    if ($answersArray[$i] == $poll_id) {
        echo "A";
        exit();
    }
}
echo "Q";
exit();