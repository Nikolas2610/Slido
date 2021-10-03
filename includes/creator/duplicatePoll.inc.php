<?php 

include '../database.inc.php';
include '../functions.inc.php';
$poll_id = $_POST['id'];
$sql = 'SELECT * FROM polls WHERE pollId=:poll_id;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':poll_id' => $poll_id
);
if (!$stmt->execute($params)) {
    // StmtFail
    echo 'queryProblem';
    exit();
}
$result = $stmt->fetch();

$peopleAnswers = emptyPollAnswersForDuplicatePoll($result->correctAnswers);
$time = date("Y-m-d H:i:s", time());

// Query to insert the event
$sql = 'INSERT INTO polls (eventId, question, answers, correctAnswers, peopleAnswers, dateCreate, pollKind, status) 
VALUES (:eventId, :question, :answers, :correctAnswers,:peopleAnswers, :dateCreate, :pollKind, :status);';
$stmt = $pdo->prepare($sql);

$params = array(
    ':eventId' => $result->eventId,
    ':question' => $result->question,
    ':answers' => $result->answers,
    ':correctAnswers' => $result->correctAnswers,
    ':peopleAnswers' => $peopleAnswers,
    ':dateCreate' => $time,
    ':pollKind' => $result->pollKind,
    ':status' => 'off'
);
if (!$stmt->execute($params)) {
    // StmtFail
    echo 'queryProblem';
    exit();
}
// Duplicate OK and echo 1 to load polls
echo 'duplicatePoll';

