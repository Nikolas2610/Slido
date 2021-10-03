<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
include '../globalVariables.inc.php';
// Declare Variables
$eventId = $_SESSION['guest_event_id'];

// Query
$sql = 'SELECT * FROM polls WHERE eventId=:eventid && status="live" ORDER BY dateCreate DESC LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
$stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
if (!$stmt->execute()) {
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();

if ($count == 0) {
    echo    ' 
    <div class="row align-items-center p-4 hoverRow text-center" id="createPoll">
        <div class="col">
            There are no active poll at the moment.
        </div>
    </div>
    <div class="row align-items-center p-4">
        <div class="col text-center">
            <a href="event.php?event=' . $_SESSION['guest_event_id'] . '&room=qa" id="events" class="button">Go to Q&A</a>
        </div>
    </div>
    ';
} else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // peopleAnswers change to integer array and after the sum of the values of the array
    $countPeopleAnswers = array_sum(array_map('intval', explode('/', $result['peopleAnswers'])));
    $answers = explode('/', $result['answers']);
    if ($result['pollKind'] == 'MP') {
        echo '
            <div class="row p-3 align-items-center border-bottom">
                <div class="col-9 display-6">' . $result['question'] . '</div>
                <div class="col-3 text-end"><span class="d-inline-block span-inline">' . $countPeopleAnswers . '</span> <i class="bi bi-people-fill"></i></div>
            </div>';
        for ($i = 0; $i < sizeof($answers); $i++) {
            echo '
                <div class="row ms-5 p-2 align-items-center">
                    <div class="row p-3 px-5">
                        <button class="questionButton pollAnswers"  id="' . $i . '">' . $answers[$i] . '</button>
                    </div>
                </div>';
        }
    } elseif ($result['pollKind'] == 'RG') {
        echo '
            <div class="row p-3 align-items-center border-bottom questionStar" id="'.$result['pollId'].'">
                <div class="col-9 display-6">' . $result['question'] . '</div>
                <div class="col-3 text-end"><span class="d-inline-block span-inline">' . $countPeopleAnswers . '</span> <i class="bi bi-people-fill"></i></div>
            </div>';
        $stars = '';
        for ($j = 0; $j < sizeof($answers); $j++) {
            $stars .= '<span><i class="bi bi-star-fill starGuest" id="' . ($j + 1) . '"></i></span>';
        }
        echo '<div class="row p-4 mt-4 align-items-center">
                    <div class="col text-center">
                        ' . $stars . '
                    </div>
                </div>
                <div class="row p-4 mt-4 align-items-center">
                    <a class="btn button" id="sendStarAnswer">Send</a>
                </div>';
    }
}
exit();
