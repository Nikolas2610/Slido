<?php
session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$eventId = $_SESSION['guest_event_id'];
$user_id = $_SESSION['userId'];

$repliesIds = array();


// Query select likes
$sql = 'SELECT * FROM guests WHERE eventId=:eventid && usersId=:userid LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId,
    ':userid' => $user_id
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (empty($result['likeMsgs'])) {
    $likeMsgs = array('0' => -1);
} else {
    $likeMsgs = changeStringArrToIntArr($result['likeMsgs']);
}


// Query to select msgs
$sql = 'SELECT * FROM msgs WHERE eventId=:eventid ORDER BY dateCreate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':eventid' => $eventId
);
if (!$stmt->execute($params)) {
    // Query error
    echo "queryProblem";
    exit();
}
$count = $stmt->rowCount();
if ($count == 0) {
    echo '
    <div class="row border-bottom p-2 hoverRow">
        <div class="col text-center">
            No Live Questions!
        </div>
    </div>';
} else {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Asc sort by likes for the Popular Tab 
    usort($results, function ($first, $second) {
        return $first['likes'] < $second['likes'];
    });

    // First element must be highlight msg if it have
    $results = highlightFirstElement($results);
    
    // Print msgs
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
        // Ckeck of the popular msg is reply
        $itsReply = 0;
        for ($i=0; $i < sizeof($results); $i++) { 
            if ($result['msgId'] == $results[$i]['reply']) {
                $itsReply = 1;
                break;
            }
        }
        if ($itsReply) {
            continue;
        }
        // Check if the message has reply message
        $reply = 0;
        if ($result['status'] > 0) {
            $messageReply = $result['reply'];
            $replyRow = array();
            while ($messageReply != -1) {
                for ($i = 0; $i < sizeof($results); $i++) {
                    if ($messageReply == $results[$i]['msgId']) {
                        $replyId = $results[$i]['msgId'];
                        $messageReply = $results[$i]['reply'];
                        array_push($repliesIds, $replyId);
                        array_push($replyRow, $results[$i]);
                        $reply++;
                        break;
                    }
                }
            }

            if ($result['status'] == 2) {
                $edit = '(edited)';
            } else {
                $edit = '';
            }
            // Check msg if highlight
            if ($result['highlight']) {
                $highlight = 'guestHighlight';
                $highlightButton = '<div class="col-1 col-lg-2 text-end "><i class="bi bi-chevron-double-up icons-size"></i></div>';
                $messageSmCols = '7';
                $messageLgCols = '7';
            } else {
                $highlight = '';
                $highlightButton = '';
                $messageSmCols = '8';
                $messageLgCols = '9';
            }
            // Check if user has a like to a msg
            for ($i = 0; $i < sizeof($likeMsgs); $i++) {
                if ($likeMsgs[$i] == $result['msgId']) {
                    $likeButton = 'blue';
                    break;
                } else {
                    $likeButton = '';
                }
            }
            // Print the reply msh
            if ($reply == 0) {
                $replyPrint = '';
            } elseif ($reply == 1) {
                // For reply like
                for ($i = 0; $i < sizeof($likeMsgs); $i++) {
                    if ($likeMsgs[$i] == $replyRow[0]['msgId']) {
                        $replyLikeButton = 'blue';
                        break;
                    } else {
                        $replyLikeButton = '';
                    }
                }
                // REPLAY 
                $replyPrint = '<div class="row align-items-center reply" id="' . $replyRow[0]['msgId'] . '">
                                    <div class="col-1 text-center">
                                        <i class="bi bi-reply-fill"></i>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col">
                                            ' . $replyRow[0]['sender'] . '
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                            ' . time_elapsed_string($replyRow[0]['dateCreate']) . '
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-end">
                                        <span id="likeValue' . $replyRow[0]['msgId'] . '">' . $replyRow[0]['likes'] . '</span><i class="bi bi-hand-thumbs-up-fill icons-size ' . $replyLikeButton . '" id="likeThumb"></i>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col">
                                        ' . $replyRow[0]['msgContent'] . '
                                        </div>
                                    </div>
                                </div>';
            } else {
                $replyPrint = '<div class="row align-items-center p-1" id="' . $replyId . '">
                <div class="col ms-2 click" id="replyGuestMsg" data-bs-toggle="modal" data-bs-target="#replyMessage" data-bs-whatever="@mdo"><i class="bi bi-reply"></i> ' . $reply . ' replies</div>
            </div>';
            }
            // Check if the msg created by the current user
            if ($result['usersId'] == $user_id) {
                $editOrDelete_dropMenu =
                    '<i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown"></i>
                <ul class="dropdown-menu" aria-labelledby="dropMenu">
                    <li><a class="dropdown-item" id="editGuestQuestion" data-bs-toggle="modal" data-bs-target="#editMsg" data-bs-whatever="@mdo">Edit</a></li>
                    <li><a class="dropdown-item" id="deleteGuestQuestion">Delete</a></li>
                </ul>';
                if ($result['highlight']) {
                    $userMsgColor = '';
                } else {
                    $userMsgColor = 'green-light';
                }
            } else {
                $editOrDelete_dropMenu = '';
                $userMsgColor = '';
            }
            echo '
            <div class="row p-2 justify-content-center mt-2 answers ' . $highlight . ' ' . $userMsgColor . '" id="' . $result['msgId'] . '">
                <div class="row align-items-center" id="guestQuestion">
                    <div class="col-1 text-center">
                        <i class="bi bi-person-fill icons-size"></i>
                    </div>
                    <div class="col-' . $messageSmCols . ' col-lg-' . $messageLgCols . '">
                        <div class="row">
                            <div class="col grey">
                                ' . $result['sender'] . '
                            </div>
                        </div>
                        <div class="row">
                            <div class="col grey">
                            ' . time_elapsed_string($result['dateCreate']) . '
                            </div>
                        </div>
                    </div>
                    ' . $highlightButton . '
                    <div class="col-3 col-lg-2 text-end"><span id="likeValue' . $result['msgId'] . '">' . $result['likes'] . '</span><i class="bi bi-hand-thumbs-up-fill icons-size ' . $likeButton . '" id="likeThumb"></i>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col" id="messageLabel' . $result['msgId'] . '">' . $result['msgContent'] . '<span> ' . $edit . '</span></div>
                    <div class="col-3 text-end">
                        ' . $editOrDelete_dropMenu . '
                    </div>
                </div>
                ' . $replyPrint . '
            </div> 
            ';
        }
    }
}
exit();
