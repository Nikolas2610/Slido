<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';

// Declare Variables
$eventId = $_SESSION['guest_event_id'];
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = $_SESSION['guest_username'];
}

// Query
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$countQuestions = 0;
for ($i=0; $i < sizeof($result); $i++) { 
    if ($result[$i]['status'] > 0) {
        $countQuestions++;
    }
}
// action="includes/guest/sendMsg.inc.php"
echo '
<div class="row question bg-light text-dark p-2 rounded" id="guestQuestion">
    <form method="POST">
        <div class="row p-2">
                <div class="col-12">
                    <label for="askQuestion" class="form-label p-2 border-bottom">Ask the speaker</label>
                    <textarea class="form-control" id="askQuestion" rows="2" placeholder="Type your question" name="msgContent"></textarea>
                </div>
        </div>
        <div class="row p-2 align-items-center justify-content-center">
            <div class="col">
                <i class="bi bi-person-fill"></i> ' . $username . '
            </div>
            <div class="col text-end">
                <button class="btn btn-success rounded-pill" name="sendMessage" type="submit" id="gusetSendMsg">Send</button>
            </div>
        </div>
    </form>
</div>

<div class="row mt-5" id="guestQuestionBar">
<nav>
    <div class="nav nav-tabs align-items-center" id="nav-tab" role="tablist">
        <button class="nav-link text-light activeTabs" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Popular</button>
        <button class="nav-link text-light activeTabs" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Recent</button>
        <div class="col text-end" id="numQuestions">' . $countQuestions . ' questions</div>
    </div>

</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div id="loadPopularQA"></div>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div id="loadRecentQA"></div>
    </div>
</div>
</div>
';
