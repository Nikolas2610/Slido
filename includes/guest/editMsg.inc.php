<?php
session_start();
if (isset($_POST['editMsg'])) {
    // Includes
    include '../database.inc.php';
    include '../functions.inc.php';
    include '../globalVariables.inc.php';

    // Declare Variables
    $msgId = $_POST['msgId'];
    $msgContent = $_POST['editMsgModal'];
    $event_id = $_SESSION['guest_event_id'];
    $status = 2;

    // check if the fields are empty
    if (empty($msgContent)) {
        header("location: " . $url . "events.php?event=" . $event_id . "&room=qa&error=emptyinput");
        exit();
    }

    if (editMsg($msgId, $msgContent, $status, $event_id)) {
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&success=editmsg");
    } else {
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
    }

    // editMsg($msgId, $msgContent, $status, $event_id);
    exit();
}
