<?php
include '../globalVariables.inc.php';
include '../functions.inc.php';


if (isset($_POST['confirmPassword'])) {
    session_start();
    $password = $_POST['password'];
    $eventid = $_SESSION['guest_event_id'];
    $username = $_SESSION['username'];

    if (empty($password)) {
        header("location: " . $url . "needPassword.php?error=emptyinput");
        exit();
    }

    if (eventGuestPasswordMatch($eventid, $password)) {
        $_SESSION['guest_pwd_match'] = 1;
        // $_SESSION['pwd'] = $password;
        header("location: " . $url . "event.php?event=" . $eventid . "&room=qa");
    } else {
        $_SESSION['pwd_match'] = 0;
        header("location: " . $url . "guestPassword.php?error=wrongoassword");
    }
}
