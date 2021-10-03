<?php
session_start();
echo "hi";
if (isset($_POST['sendMessage'])) {
    // Includes
    include '../database.inc.php';
    include '../functions.inc.php';
    include '../globalVariables.inc.php';
    echo "hi";
    // $msgContent = $_POST['msgContent'];
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $username = $_SESSION['guest_username'];
    }
    $event_id = $_SESSION['guest_event_id'];
    $user_id = $_SESSION['userId'];
    if ($_SESSION['reviewQa'] == 0) {
        $status = 1;
    } else {
        $status = 0;
    }

    // check if the fields are empty
    if (empty($msgContent)) {
        header("location: " . $url . "event.php?event=".$event_id."&room=qa&error=emptyinput");
        exit();
    }

    sendMsg($event_id, $username, $msgContent, $status, $user_id);
}
