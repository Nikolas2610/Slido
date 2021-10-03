<?php

session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];


// Query
$sql = 'SELECT * FROM polls WHERE eventId=:eventid && status="live" ORDER BY dateCreate DESC LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
$stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
if (!$stmt->execute()) {
    echo "Problem with query";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}
$count = $stmt->rowCount();
echo '<div class="row p-3 rounded-pill border-bottom mb-3 mt-3"
<div class="col">
    <h3>Live poll</h3>
</div>
</div>';
if ($count == 0) {
    echo    ' 
    <div class="row align-items-center p-4 hoverRow">
        <div class="col">
            You have to run a poll live first!
        </div>
    </div>';
} else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $answers = explode('/', $result['answers']);
    $peopleAnswersIntArray = array_map('intval', explode('/', $result['peopleAnswers']));
    $countPeopleAnswers = array_sum($peopleAnswersIntArray);
    if ($result['pollKind'] == 'MP') {
        // peopleAnswers change to integer array and after the sum of the values of the array
        $correctAnswer = getCorrectAnswer($result['correctAnswers']);

        echo '
        <div class="row p-3 align-items-center border-bottom">
            <div class="col-9 display-6">' . $result['question'] . '</div>
            <div class="col-3 text-end"><span class="d-inline-block span-inline">' . $countPeopleAnswers . '</span> <i class="bi bi-people-fill"></i></div>
        </div>';
        for ($i = 0; $i < sizeof($answers); $i++) {
            // Find the percentage of the current answer with 2 decimal 
            $answerPercentage = getAnswerPercentage($peopleAnswersIntArray[$i], $countPeopleAnswers);
            // Print correct answer
            if ($i == $correctAnswer && $correctAnswer !== NULL) {
                $printCorrectAnswer = "border border-success border-4 rounded";
            } else {
                $printCorrectAnswer = "";
            }
            // The id of the answer(div) is the counter($i)
            echo '
            <!-- Answers -->
            <!-- Answer 1 -->
            <div class="row m-3 p-2 align-items-center ' . $printCorrectAnswer . '" id="' . $i . '">
                <div class="p-1">
                    ' . $answers[$i] . '
                </div>
                <div class="p-1">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: ' . $answerPercentage . '%" aria-valuenow="' . $answerPercentage . '" aria-valuemin="0" aria-valuemax="100">' . $answerPercentage . '%</div>
                    </div>
                </div>
            </div>';
        }
    } elseif ($result['pollKind'] == 'RG') {
        echo '
        <div class="row p-3 align-items-center border-bottom">
            <div class="col-9 display-6">' . $result['question'] . '</div>
            <div class="col-3 text-end"><span class="d-inline-block span-inline">' . $countPeopleAnswers . '</span> <i class="bi bi-people-fill"></i></div>
        </div>';
        for ($i = 0; $i < sizeof($answers); $i++) {
            // Find the percentage of the current answer with 2 decimal 
            $answerPercentage = getAnswerPercentage($peopleAnswersIntArray[$i], $countPeopleAnswers);
            $stars = '';
            for ($j = 0; $j < $answers[$i]; $j++) {
                $stars .= '<i class="bi bi-star-fill"></i>';
            }
            // The id of the answer(div) is the counter($i)
            echo '
            <!-- Answers -->
            <!-- Answer 1 -->
            <div class="row m-3 p-2 align-items-center" id="' . $i . '">
                <div class="p-1 yellowStars">
                    ' . $stars . '
                </div>
                <div class="p-1">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: ' . $answerPercentage . '%" aria-valuenow="' . $answerPercentage . '" aria-valuemin="0" aria-valuemax="100">' . $answerPercentage . ' %</div>
                    </div>
                </div>
            </div>';
        }
    }
    exit();
}
