<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['event_id'];
$repliesIds = array();



// Query
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid ORDER BY dateCreate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
if (!$stmt->execute($params)) {
    // Query error
    echo "0";
    exit();
}
$count = $stmt->rowCount();
echo '<div class="row p-3 rounded-pill border-bottom mb-5 mt-3"
<div class="col">
    <h3>Live Q&A</h3>
</div>
</div>';
if ($count == 0) {
    echo '
    <div class="row border p-3 hoverRow">
        <div class="col text-center">
            No Live Questions!
        </div>
    </div>';
} else {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $results = highlightFirstElement($results);
    foreach ($results as $result) {
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
        if ($result['status'] > 0) {
                $messageReply = $result['reply']; 
                while ($messageReply != -1) {
                    for ($i = 0; $i < sizeof($results); $i++) {
                        if ($messageReply == $results[$i]['msgId']) {
                            $replyId = $results[$i]['msgId'];
                            $messageReply = $results[$i]['reply'];
                            array_push($repliesIds, $replyId);
                            $reply++;
                            break;
                        }
                    }
                }
            // Print the reply msh
            if ($reply == 0) {
                $replyPrint = '';
            } else {
                if ($reply == 1) {
                    $replyPrint = '<div class="row align-items-center p-1" id="' . $replyId . '">
                    <div class="col ms-2 click black" id="replyMsg" data-bs-toggle="modal" data-bs-target="#replyMessage" data-bs-whatever="@mdo"><i class="bi bi-reply"></i> ' . $reply . ' reply</div>
                </div>';
                } else {
                    $replyPrint = '<div class="row align-items-center p-1" id="' . $replyId . '">
                    <div class="col ms-2 click black" id="replyMsg" data-bs-toggle="modal" data-bs-target="#replyMessage" data-bs-whatever="@mdo"><i class="bi bi-reply"></i> ' . $reply . ' replies</div>
                </div>';
                }
            }
            if ($result['highlight']) {
                $highlight = 'highlight';
            } else {
                $highlight = '';
            }
            // Check if msg is edid and print 
            if ($result['status'] == 2) {
                $edit = '(edited)';
            } else {
                $edit = '';
            }
            // Print message
            echo '
            <div class="row border-bottom p-2 hoverRow msgs ' . $highlight . '" id="' . $result['msgId'] . '">
                <div class="row align-items-center">
                    <div class="col text-center">
                        <i class="bi bi-person-fill icons-size"></i>
                    </div>
                    <div class="col-8 text-center">
                        <div class="row">
                        <div class="col text-start">' . $result['sender'] . '</div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg text-start">' . $result['likes'] . ' <i class="bi bi-hand-thumbs-up-fill"></i> &ensp;' . time_elapsed_string($result['dateCreate']) . '</div>
                        </div>
                    </div>
                    <div class="col-1 d-none d-sm-block" id="declineQuestion">
                        <i class="bi bi-check2 icons-size" title="Mark as answered"></i>
                    </div>
                    <div class="col-1">
                        <i class="bi bi-chevron-double-up icons-size" id="highlightQuestion" data-bs-toggle="tooltip" data-bs-placement="top" title="Highlight"></i>
                    </div>
                    <div class="col-1">
                        <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown" id="msgDrop"></i>
                        <ul class="dropdown-menu" aria-labelledby="dropMenu">
                            <li><a class="dropdown-item click" id="editCreatorQuestion" data-bs-toggle="modal" data-bs-target="#editMsg" data-bs-whatever="@mdo">Edit</a></li>
                            <li><a class="dropdown-item click" id="replyQuestion" data-bs-toggle="modal" data-bs-target="#replyMessage" data-bs-whatever="@mdo">Reply</a></li>
                            <li><a class="dropdown-item click" id="archiveQuestion">Archive</a></li>
                            <li><a class="dropdown-item click" id="declineQuestion">Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row align-items-center p-1">
                    <div class="col" id="messageLabel' . $result['msgId'] . '">' . $result['msgContent'] . '<span> ' . $edit . '</span></div>
                </div>
                ' . $replyPrint . '
            </div>
            ';
        }
    }
}
