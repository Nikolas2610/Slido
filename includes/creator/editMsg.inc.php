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
    $status = 2;

    // check if the fields are empty
    if (empty($msgContent)) {
        header("location: " . $url . "qa.php?qa=live&error=emptyinput");
        exit();
    }

    if (editMsg($msgId, $msgContent, $status)) {
        header("location: " . $url . "qa.php?qa=live&success=editmsg");
    } else {
        header("location: " . $url . "qa.php?qa=live&error=stmtfailed");
    }
    exit();
}
