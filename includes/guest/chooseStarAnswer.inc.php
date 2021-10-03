<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';

$pollid = $_POST['id'];
$answerId = $_POST['answer'];
$eventId = $_SESSION['guest_event_id'];
$user_id = $_SESSION['userId'];

// Query to select the curent poll
$sql = 'SELECT * FROM polls WHERE pollId=:pollId LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':pollId' => $pollid
);
if (!$stmt->execute($params)) {
    echo "queryProblem";
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// Update Answers
$peopleAnswers = changeStringArrToIntArr($result['peopleAnswers']);
$peopleAnswers[($answerId - 1)]++;
$answerString = changeIntArrToString($peopleAnswers);

// Query to update the peopleAnswers
$sql = "UPDATE polls SET peopleAnswers=:answer WHERE pollId=:id;";
$stmt = $pdo->prepare($sql);
$params = array(
    ':id' => $pollid,
    ':answer' => $answerString
);
// Check query
if (!$stmt->execute($params)) {
    echo "queryProblem";
    exit();
}

$count = $stmt->rowCount();
if ($count == '0') {
    echo "queryProblem";
    exit();
} else {
    // Query to select the answers of the guest
    $sql = 'SELECT * FROM guests WHERE usersId=:user_id && eventId=:event_id LIMIT 1;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':user_id' => $user_id,
        ':event_id' => $eventId,
    );
    if (!$stmt->execute($params)) {
        // Problem with query
        echo "queryProblem";
        exit();
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // Add the previous poll IDs with the new poll ID
    $newanswers = $result['answers'] . $pollid . '/';
    // Query to update the password
    $sql = "UPDATE guests SET answers=:poll_id 
    WHERE usersId=:user_id && eventId=:event_id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':poll_id' => $newanswers,
        ':user_id' => $user_id,
        ':event_id' => $eventId
    );
    // Check query
    if (!$stmt->execute($params)) {
        // Problem with query
        echo "queryProblem";
        exit();
    }
    echo "success";
    exit();
}
