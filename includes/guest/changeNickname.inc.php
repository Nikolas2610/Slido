<?php
session_start();
if (isset($_POST['changeNicknameBtn'])) {
    // Includes
    include '../database.inc.php';
    include '../functions.inc.php';
    include '../globalVariables.inc.php';

    // Declare Variables
    $nickname = $_POST['nickname'];
    $event_id = $_SESSION['guest_event_id'];
    $user_id = $_SESSION['userId'];

    // check if the fields are empty
    if (empty($nickname)) {
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=emptyinput");
        exit();
    }

    if (updateGuestNickname($nickname, $event_id, $user_id)) {
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&success=updatenickname");
        $_SESSION['guest_username'] = $nickname;
    } else {
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
    }
    exit();
}