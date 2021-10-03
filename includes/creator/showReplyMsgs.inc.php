<?php

session_start();
include '../database.inc.php';
include '../functions.inc.php';
// Declare Variables
$user_id = $_SESSION['userId'];

$msg_id = $_POST['id'];
$hasreply = 1;
$msgButtons = 1;
$printMsgs = 0;


while ($hasreply == 1) {
    $sql = 'SELECT * FROM msgs WHERE msgId=:msg_id;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':msg_id' => $msg_id
    );
    if (!$stmt->execute($params)) {
        // StmtFail
        echo 0;
        exit();
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($msgButtons == 1) {
        $buttonsMsgs = '<div class="col-1 d-none d-sm-block" id="declineQuestion">
        <i class="bi bi-check2 icons-size" title="Mark as answered"></i>
    </div>
    <div class="col-1">
        <i class="bi bi-chevron-double-up icons-size" id="highlightQuestion" data-bs-toggle="tooltip" data-bs-placement="top" title="Highlight"></i>
    </div>';
        $msgButtons = 0;
    } else {
        $buttonsMsgs = '<div class="col-1 d-none d-sm-block" ></div>
        <div class="col-1"></div>';
    }
    if ($result['usersId'] == $user_id) {
        $color = 'greyBG';
    } else {
        $color = '';
    }
    if ($printMsgs == 0) {
        $mainMsg = 'mainMsg';
    } else {
        $mainMsg = '';
    }

    // Echo messages
    echo '
    <div class="row border-bottom p-1 msgs ' . $color . ' ' . $mainMsg . '" id="' . $result['msgId'] . '">
        <div class="row align-items-center">
            <div class="col text-center">
                <i class="bi bi-person-fill icons-size"></i>
            </div>
            <div class="col-8 text-center">
                <div class="row">
                    <div class="col text-start">' . $result['sender'] . '</div>
                </div>
                <div class="row">
                    <div class="col-lg-2 text-start">' . $result['likes'] . ' <i class="bi bi-hand-thumbs-up-fill"></i></div>
                    <div class="col-lg-10 text-start">' . $result['dateCreate'] . '</div>
                </div>
            </div>
            ' . $buttonsMsgs . '
            <div class="col-1">
                <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown" id="test5"></i>
                <ul class="dropdown-menu" aria-labelledby="dropMenu">
                    <li><a class="dropdown-item click" id="editCreatorQuestion" data-bs-toggle="modal" data-bs-target="#editMsg" data-bs-whatever="@mdo">Edit</a></li>
                    <li><a class="dropdown-item click" id="declineReplyQuestion">Delete</a></li>
                </ul>
            </div>
        </div>
        <div class="row align-items-center p-1">
            <div class="col" id="messageLabel' . $result['msgId'] . '">' . $result['msgContent'] . '<span></span></div>
        </div>
    </div>';

    $printMsgs++;
    // Chech if message has reply
    if ($result['reply'] == -1) {
        $hasreply = 0;
    } else {
        $msg_id = $result['reply'];
    }
}
$_SESSION['msg_id'] = $msg_id;
exit();
