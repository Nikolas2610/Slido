<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];


// Query
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid && status=:status ORDER BY dateCreate DESC;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':status' => 0
);
if (!$stmt->execute($params)) {
    // Query error
    echo "0";
    exit();
}
$count = $stmt->rowCount();
// $result = $stmt->fetch(PDO::FETCH_ASSOC);
echo '<div class="row p-3 rounded-pill border-bottom mb-5 mt-3">
<div class="col">
    <h3>Review Q&A</h3>
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
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($result['status'] == 0) {
            echo '
                <div class="row border-bottom p-2 hoverRow msgs" id="' . $result['msgId'] . '">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <i class="bi bi-person-fill icons-size"></i>
                        </div>
                        <div class="col-7 col-lg-9 text-center">
                            <div class="row ">
                                ' . $result['sender'] . '
                            </div>
                            <div class="row">
                                ' . time_elapsed_string($result['dateCreate']) . '
                            </div>
                        </div>
                        <div class="col-1" id="declineQuestion">
                            <i class="bi bi-x icons-size"></i>
                        </div>
                        <div class="col-1">
                            <i class="bi bi-check2 icons-size" id="acceptQuestion"></i>
                        </div>
                    </div>
                    <div class="row align-items-center p-1">
                        <div class="col ms-2" id="messageLabel' . $result['msgId'] . '">' . $result['msgContent'] . '</div>
                    </div>
                </div>';
        }
    }
}
