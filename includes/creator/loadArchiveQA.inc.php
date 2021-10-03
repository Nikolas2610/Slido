<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$repliesIds = array();

// Query
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid && status=:status ORDER BY dateCreate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':status' => -1
);
if (!$stmt->execute($params)) {
    // Query error
    echo "0";
    exit();
}
$count = $stmt->rowCount();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo '<div class="row p-3 rounded-pill border-bottom mb-5 mt-3"
<div class="col">
    <h3>Archive Q&A</h3>
</div>
</div>';
if ($count == 0) {
    echo '
    <div class="row border p-3 hoverRow">
        <div class="col text-center">
            No Questions to review
        </div>
    </div>';
} else {
    foreach ($results as $result) {
        // echo $result['msgId'] .'______'. $result['reply'] ;
        // echo '<br>';

        // Check if the msg is reply to other msg 
        $hasPrint = 0;
        for ($i = 0; $i < sizeof($repliesIds); $i++) {
            if ($repliesIds[$i] == $result['msgId']) {
                $hasPrint = 1;
            }
        }
        // Continue if the msg has print
        if ($hasPrint) {
            continue;
        }
        // Check if the message has reply message
        $reply = 0;
        $messageReply = $result['reply'];
        while ($messageReply != -1) {
            for ($i = 0; $i < sizeof($results); $i++) {
                if ($messageReply == $results[$i]['msgId']) {
                    $replyId = $results[$i]['msgId'];
                    $messageReply = $results[$i]['reply'];
                    array_push($repliesIds, $replyId);
                    // print_r($repliesIds);
                    // echo "<br>-----<br>";
                    break;
                }
            }
        }

        echo '
                <div class="row border-bottom p-2 hoverRow msgs" id="' . $result['msgId'] . '">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <i class="bi bi-person-fill icons-size"></i>
                        </div>
                        <div class="col-9 text-center">
                            <div class="row ">
                                ' . $result['sender'] . '
                            </div>
                            <div class="row">
                                ' . time_elapsed_string($result['dateCreate']) . '
                            </div>
                        </div>
                        <div class="col-1 d-none d-sm-block" id="declineQuestion">
                            <i class="bi bi-x icons-size"></i>
                        </div>
                        <div class="col-1">
                            <i class="bi bi-arrow-counterclockwise icons-size" id="acceptQuestion"></i>
                        </div>
                    </div>
                    <div class="row align-items-center p-1">
                        <div class="col ms-2" id="messageLabel' . $result['msgId'] . '">' . $result['msgContent'] . '</div>
                    </div>
                </div>';
    }

}

