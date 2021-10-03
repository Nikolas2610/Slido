<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$startButton = '<i class="bi bi-play-circle-fill icons-size" id="playButton"></i>';
$stopButton = '<i class="bi bi-stop-circle-fill icons-size" id="stopButton"></i>';




// Query
$sql = 'SELECT * FROM polls WHERE eventId=:eventid ORDER BY dateCreate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
$stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
if (!$stmt->execute()) {
    echo "Problem with query2";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}
$count = $stmt->rowCount();
echo '<div class="row p-3 rounded-pill border-bottom mb-3 mt-3"
<div class="col">
    <h3>List polls</h3>
</div>
</div>';
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
    echo '
    <div class="row border-bottom p-2 align-items-center">
        <div class="col-7">List</div>
        <div class="col-5 text-end"><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newPoll" data-bs-whatever="@mdo">Create Poll</a></div>
    </div>
    ';
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // peopleAnswers change to integer array and after the sum of the values of the array
        $countPeopleAnswers = array_sum(array_map('intval', explode('/', $result['peopleAnswers'])));
        // Set play ot stop button
        if ($result['status'] == "off") {
            $button = $startButton;
        } else if ($result['status'] == "live") {
            $button = $stopButton;
        }
        if ($result['showAnswers'] == 0) {
            $iconShowAnswers = '';
        } else {
            $iconShowAnswers = 'colorShowAnswers';
        }
        // Find and print the correct icon
        $pollkind = pollKind($result['pollKind']);
        $pollIcon = findPollIcon($result['pollKind']);
        echo '
        <div class="row border-bottom p-2 hoverRow poll" id="' . $result['pollId'] . '">
            <div class="row align-items-center">
                <div class="col text-center">
                    ' . $pollIcon . '
                </div>
                <div class="col-8 text-center">
                    <div class="row ">
                        ' . $pollkind . '
                    </div>
                    <div class="row">
                        Votes: <span class="d-inline-block span-inline">' . $countPeopleAnswers . ' </span>
                        <span class="d-inline-block span-inline"><i class="bi bi-filter-left"></i></span>
                    </div>
                </div>
                <div class="col-1 d-none d-sm-block">
                    <i class="bi bi-filter-left icons-size showAnswers ' . $iconShowAnswers . '" id="' . $result['showAnswers'] . '" ></i>
                </div>
                <div class="col-1" id="startStopButtonDiv">
                    ' . $button . '
                </div>
                <div class="col-1">
                    <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropMenu">
                        <li><a class="dropdown-item" id="editPollButton" data-bs-toggle="modal" data-bs-target="#editPoll" data-bs-whatever="@mdo">Edit</a></li>
                        <li><a class="dropdown-item" id="duplicatePollButton">Duplicate</a></li>
                        <li><a class="dropdown-item" id="deletePollButton">Delete</a></li>
                    </ul>
                </div>
            </div>
            <div class="row align-items-center p-1">
                <div class="col ms-2" id="poll' . $result['pollId'] . '">' . $result['question'] . '</div>
            </div>
        </div>
    ';
    }
    echo    ' 
    <div class="row align-items-center border-bottom p-4 hoverRow" id="createPoll">
        <div class="col">
            <a data-bs-toggle="modal" data-bs-target="#newPoll" data-bs-whatever="@mdo"><i class="bi bi-plus "></i> Create a Poll</a>
        </div>
    </div>';
}
