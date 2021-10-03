<?php
session_start();

if (isset($_POST['sendMessage'])) {
    // Includes
    include '../database.inc.php';
    include '../functions.inc.php';
    include '../globalVariables.inc.php';
    $msgContent = $_POST['msg'];
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
        // header("location: " . $url . "event.php?event=".$event_id."&room=qa&error=emptyinput");
        echo 'emptyMsg';
        exit();
    }

    $output = sendMsg($event_id, $username, $msgContent, $status, $user_id);
    if ($output == 0) {
        echo 'queryProblem';
    } elseif ($output == 1) {
        echo 'msgSend';
    } elseif ($output == 2) {
        echo 'msgReview';
    }
    exit();
}
