<?php
session_start();
include '../globalVariables.inc.php';
include '../functions.inc.php';


if (isset($_POST['join'])) {
    // Create Variables
    $event_id = $_POST['joinEventHome'];
    $_SESSION['guest_event_id'] = $event_id;

    // Check if the input is empty
    if (empty($event_id)) {
        header("location: " . $url . "index.php?error=emptyinput");
        exit();
    }
    
    // Import guest to guestTable   
    if (isset($_SESSION['userId'])) {
        if (!findGuest($_SESSION['userId'], $_SESSION['guest_event_id'])) {
            createGuest($_SESSION['userId'], $_SESSION['guest_event_id']);
            updateGuestNickname($_SESSION['username'], $event_id, $_SESSION['userId']);
        }
    } else {
        if (isset($_COOKIE['guest_username'])) {
            if (!findGuest($_COOKIE['guest_username'], $_SESSION['guest_event_id'])) {
                createGuest($_COOKIE['guest_username'], $_SESSION['guest_event_id']);
            }
        } else {
            $guestUsernameCookie = getRandomCookieId();
            setcookie('guest_username', $guestUsernameCookie);
            createGuest($guestUsernameCookie, $_SESSION['guest_event_id']);
        }
        $_SESSION['userId'] = $guestUsernameCookie;
    }


    joinEvent($event_id);
    exit();
}
