<?php
session_start();
// Include files
include 'includes/database.inc.php';
include 'includes/functions.inc.php';
include 'includes/globalVariables.inc.php';

// Decline Variables
$link = $_GET['link'];
$eventid = base64_decode($link);
$_SESSION['guest_event_id'] = $eventid;

// Query
$sql = 'SELECT * FROM events WHERE publishId=:event_id LIMIT 1;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':event_id' => $eventid
);
if (!$stmt->execute($params)) {
    // Problem with query
    header("location: " . $url . "index.php?error=stmtmerror");
    exit();
}
$count = $stmt->rowCount();
if ($count == 0) {
    // No events
    header("location: " . $url . "index.php?error=notexistsevent");
    exit();
} else {
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

    joinEvent($eventid);
    // $result = $stmt->fetch();
    // $_SESSION['guest_event_id'] = $result->publishId;
    // $_SESSION['guest_event_name'] = $result->eventName;
    // if ($result->eventStatus == 1) {
    //     // When event is private goes to check password event
    //     header("location: " . $url . "guestPassword.php");
    //     echo "private room";
    //     exit();
    // }
    // header("location: " . $url . "event.php?event=" . $result->publishId . "&room=qa");
    exit();
}
