<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];

// Query to select all the polls of the current event
$sql = 'SELECT * FROM polls WHERE eventId=:eventid ORDER BY dateCreate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
if (!$stmt->execute($params)) {
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();
if ($count == 0) {
    echo    ' 
    <div class="row p-2 align-items-center">
        <div class="col-7">List</div>
        <div class="col-5 text-end"><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newPoll" data-bs-whatever="@mdo">Create Poll</a></div>
    </div>
    <div class="row align-items-center p-3 hoverRow" id="createPoll">
        <div class="col">
            <i class="bi bi-plus"></i><a class="btn text-light" data-bs-toggle="modal" data-bs-target="#newPoll" data-bs-whatever="@mdo">No Polls. Let create a Poll!</a></div>
        </div>
    </div>';
} else {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $counter = 1;
    echo '<div class="row p-3 rounded-pill border-bottom mb-5 mt-3"
        <div class="col">
            <h3>All results polls</h3>
        </div>
    </div>';
    echo '<div class="accordion accordion-flush" id="accordionFlush">';

    foreach ($results as $result) {
        $answers = explode('/', $result['answers']);
        $peopleAnswersIntArray = array_map('intval', explode('/ ', $result['peopleAnswers']));
        $countPeopleAnswers = array_sum($peopleAnswersIntArray);
        $pollIcon = findPollIcon($result['pollKind']);

        if ($result['pollKind'] == 'MP') {
            $correctAnswer = getCorrectAnswer($result['correctAnswers']);
            $printAnswers = '';
            for ($i = 0; $i < sizeof($answers); $i++) {
                // Print correct answer
                if ($i == $correctAnswer && $correctAnswer !== NULL) {
                    $printCorrectAnswer = "border border-success border-4 rounded";
                } else {
                    $printCorrectAnswer = "";
                }
                $answerPercentage = getAnswerPercentage($peopleAnswersIntArray[$i], $countPeopleAnswers);
                $printAnswers .= '<div class="row p-2 ms-md-5 align-items-center ' . $printCorrectAnswer . '">
                <div class="p-1">
                    ' . $answers[$i] . '
                </div>
                <div class="p-1">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success text-light" role="progressbar" style="width: ' . $answerPercentage . '%" aria-valuenow="' . $answerPercentage . '" aria-valuemin="0" aria-valuemax="100">' . $answerPercentage . '%</div>
                    </div>
                </div>
            </div>';
            }
            echo '
        <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed fs-5 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $counter . '" aria-expanded="false" aria-controls="flush-collapse' . $counter . '">
                <div class="col-9">
                    <div class="col-9 fs-5">' . $pollIcon . ' ' . $result['question'] . '</div>
                </div>
                <div class="col-2 text-end">
                    ' . $countPeopleAnswers . ' <i class="bi bi-people-fill"></i>
                </div>
            </button>
        </h2>
        <div id="flush-collapse' . $counter . '" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
            <div class="accordion-body text-dark">
               ' . $printAnswers . '
            </div>
        </div>
    </div>
        ';
        } elseif ($result['pollKind'] == 'RG') {

            $printAnswers = '';
            for ($i = 0; $i < sizeof($answers); $i++) {
                $answerPercentage = getAnswerPercentage($peopleAnswersIntArray[$i], $countPeopleAnswers);
                $stars = '';
                for ($j = 0; $j < $answers[$i]; $j++) {
                    $stars .= '<i class="bi bi-star-fill"></i>';
                }
                $printAnswers .= '
                <div class="row m-3 p-2 align-items-center" id="">
                    <div class="p-1 text-warning">
                        ' . $stars . '
                    </div>
                    <div class="p-1">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: ' . $answerPercentage . '%" aria-valuenow="' . $answerPercentage . '" aria-valuemin="0" aria-valuemax="100">' . $answerPercentage . ' %</div>
                        </div>
                    </div>
                </div>
                ';
            }
            echo '
            <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed fs-5 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $counter . '" aria-expanded="false" aria-controls="flush-collapse' . $counter . '">
                    <div class="col-9">
                        <div class="col-9 fs-5">' . $pollIcon . ' ' . $result['question'] . '</div>
                    </div>
                    <div class="col-2 text-end">
                        ' . $countPeopleAnswers . ' <i class="bi bi-people-fill"></i>
                    </div>
                </button>
            </h2>
            <div id="flush-collapse' . $counter . '" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
                <div class="accordion-body text-dark">
                    ' . $printAnswers . '
                </div>
            </div>
        </div>
            ';
        }
        $counter++;
    }




    echo '</div>';
    // print_r($results);
}
