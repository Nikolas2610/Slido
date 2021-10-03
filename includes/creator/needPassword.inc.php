<?php
include '../globalVariables.inc.php';
include '../functions.inc.php';


if (isset($_POST['confirmPassword'])) {
    session_start();
    $password = $_POST['password'];
    $eventid = $_SESSION['event_id'];
    $username = $_SESSION['username'];

    if (empty($password)) {
        header("location: " . $url . "needPassword.php?error=emptyinput");
        exit();
    }

    if (eventPasswordMatch($username, $eventid, $password)) {
        $_SESSION['pwd_match'] = 1;
        $_SESSION['pwd'] = $password;
        // header("location: " . $url . "polls.php?poll=list");
        if ($_SESSION['goes_to'] == 'eventSettings') {
            header("location: " . $url . "eventsettings.php");
        } elseif ($_SESSION['goes_to'] == 'joinEvent') {
            header("location: " . $url . "polls.php?poll=list");
        }
    } else {
        $_SESSION['pwd_match'] = 0;
        header("location: " . $url . "needPassword.php?error=wrongoassword&for=join");
        // if ($_SESSION['goes_to'] == 'eventSettings') {
        //     header("location: " . $url . "needPassword.php?error=wrongoassword&for=settings");
        // } elseif ($_SESSION['goes_to'] == 'join') {
        //     $_SESSION['pwd_match'] = 0;   // If a need to ask the passwrod to edit the event settings
        //     header("location: " . $url . "needPassword.php?error=wrongoassword&for=join");
        // }
    }
}
