<?php
session_start();
if (isset($_POST['inviteByEmail'])) {
    include '../functions.inc.php';
    include 'globalVariables.inc.php';
    $inviteUrl = $_POST['shareLink'];
    $username = $_SESSION['username'];
    $mail = array();


    // Create one string for the answers and the correctAnswers
    for ($i = 1; $i < 5; $i++) {
        if (!empty($_POST['email' .  $i])) {
            // Push Email to array
            array_push($mail, $_POST['email' .  $i]);
        } else {
            break;
        }
    }
    // check if the fields are empty
    if (empty($mail[0])) {
        header("location: ../events.php?error=emptyEmail");
        exit();
    }
    sendInviteByEmail($mail, $username, $inviteUrl);

    exit();



} else {
    // If not set back to events.php
    header("location: ../events.php");
    exit();
};
