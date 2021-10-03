<?php
session_start();
if (isset($_POST['sendReply'])) {
    // Includes
    include '../database.inc.php';
    include '../functions.inc.php';
    include '../globalVariables.inc.php';

    // Declare Variables
    $msgId = $_SESSION['msg_id'];
    $replyContent = $_POST['replyContent'];
    $event_id = $_SESSION['event_id'];
    $username = $_SESSION['username'];
    $user_id = $_SESSION['userId'];
    $status = 1;

    // check if the fields are empty
    if (empty($replyContent)) {
        header("location: " . $url . "qa.php?qa=live&error=emptyReplyInput");
        exit();
    }

    if (replyMsg($event_id, $username, $replyContent, $status, $user_id, $msgId)) {
        header("location: " . $url . "qa.php?qa=live&success=replymsg");
    } else {
        header("location: " . $url . "qa.php?qa=live&error=stmtfailed");
    }
    exit();
}
