<?php
session_start();
// Include Files
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$poll_id = $_POST['id'];
$_SESSION['poll_id'] = $poll_id;

// Query to load poll
$sql = 'SELECT * FROM polls WHERE pollId=:poll_id;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':poll_id' => $poll_id
);
if (!$stmt->execute($params)) {
    // StmtFail
    echo 0;
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($result);
$pollKind = pollkind($result['pollKind']);
$question = $result['question'];
if ($result['pollKind'] == 'MP') {
    // $answers = $result['answers'];
    $correctAnswers = changeStringArrToIntArr($result['correctAnswers']);
    $answers = explode('/', $result['answers']);
    for ($i = 0; $i < sizeof($correctAnswers); $i++) {
        if ($correctAnswers[$i] == 1) {
            $markAnswers = 'checked';
            break;
        } else {
            $markAnswers = '';
        }
    }
    $pollAnswerLabel = '';
    for ($i = 0; $i < sizeof($answers); $i++) {
        if ($markAnswers == 'checked') {
            if ($correctAnswers[$i] == 0) {
                $correctAnswer = '';
            } else {
                $correctAnswer = 'checked';
            }
        } else {
            $correctAnswer = 'disabled';
        }
        // Remove the spaces from the anwers
        if ($answers[$i][0] == " ") {
            $answers[$i] = substr($answers[$i], 1);
        }
        $pollAnswerLabel .= '
        <div class="form-check mb-3">
            <div class="row align-items-center">
                <div class="col-1">
                    <input class="form-check-input markEditAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer' . ($i + 1) . '" ' . $correctAnswer . '>
                </div>
                <div class="col-11">
                    <input type="text" class="form-control option" placeholder="Add option" name="option' . ($i + 1) . '" value="' . $answers[$i] . '">
                </div>
            </div>
        </div>';
    }


    echo '
    <div class="mb-3">
        <label for="question" class="form-label fs-5 title" id="MP">' . $pollKind . ' Title</label>
        <input type="text" class="form-control" id="editQuestion" placeholder="What would you like to ask?" name="editQuestion" value="' . $question . '">
    </div>
    <div class="form-check mb-3">
        <button class="btn btn-success" id="addEditAnswer" type="button">Add answer</button>
    </div>
    <div id="pollEditAnswers">
    ' . $pollAnswerLabel . '
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="markEditAnswers" name="markEditAnswers" ' . $markAnswers . '>
            <label class="form-check-label" for="markEditAnswers">
                Mark Correct Answers
            </label>
        </div>
    </div>
    <div class="mb-3 text-center">
        <div class="alert alert-danger noneDisplay errorMsgs" role="alert">Empty Question</div>
    </div>
';
} elseif ($result['pollKind'] == 'RG') {
    // Create stars
    $answers = explode('/', $result['answers']);
    $countStars = sizeof($answers);
    $stars = '';
    for ($i = 0; $i < 10; $i++) {
        if ($i < $countStars) {
            // Check - Fill star
            $stars .= '<i class="bi bi-star-fill formStar check" id="' . ($i + 2) . '"></i>';
        } else {
            // Uncheck - no fill star
            $stars .= '<i class="bi bi-star formStar" id="' . ($i + 2) . '"></i>';
        }
    }

    // Print Edit Form
    echo '
    <div class="mb-3">
        <label for="question" class="form-label fs-5 title" id="RG">' . $pollKind . ' Title</label>
        <input type="text" class="form-control" id="editQuestion" placeholder="What would you like to ask?" name="editQuestion" value="' . $question . '">
    </div>
    <div class="mb-3 text-center">
        <p class="starsText">Choose how many stars (Max stars: 10)</p>
    </div>
    <div class="mb-3 text-center">
    <div id="stars">
        ' . $stars . '
    </div>
    <div class="mb-3 text-center">
        <div class="alert alert-danger noneDisplay errorMsgs" role="alert">Empty Question</div>
    </div>
</div>
';
}
exit();
