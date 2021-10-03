<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';

$pollid = $_SESSION['poll_id'];
$answerId = $_POST['id'];
$eventId = $_SESSION['guest_event_id'];
$user_id = $_SESSION['userId'];

// Query to select the curent poll
$sql = 'SELECT * FROM polls WHERE eventId=:eventid && pollId=:pollId LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':pollId' => $pollid
);
if (!$stmt->execute($params)) {
    echo "Problem with query";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$peopleAnswers = changeStringArrToIntArr($result['peopleAnswers']);
$peopleAnswers[$answerId]++;
$answerString = changeIntArrToString($peopleAnswers);

// Query to update the password
$sql = "UPDATE polls SET peopleAnswers=:answer WHERE pollId=:id;";
$stmt = $pdo->prepare($sql);
$params = array(
    ':id' => $pollid,
    ':answer' => $answerString
);
$stmt->bindParam(':id', $params[':id'], PDO::PARAM_INT);
$stmt->bindParam(':answer', $params[':answer'], PDO::PARAM_STR);
// Check query
if (!$stmt->execute()) {
    echo "Problem with query";
    // header("location: ../resetPassword.php?error=stmtfailed");
    exit();
}
$count = $stmt->rowCount();
if ($count == '0') {
    echo "Something het wrong with question!";
    // header("location: ../resetPassword.php?error=noresults");
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
        echo 0;
        // header("location: " . $url . "index.php?error=notuserfind");
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
        echo 0;
        // header("location: ../resetPassword.php?error=stmtfailed");
        exit();
    }
}
exit();
