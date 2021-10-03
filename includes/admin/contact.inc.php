<?php 

if (isset($_POST['sendMsg'])) {
    // Include files
    include '../functions.inc.php';
    include '../globalVariables.inc.php';
    // Declare Variables
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $comments = $_POST['comments'];
    // Create cookies for keep the values of the users if something get wrong
    setcookie('contact_firstName', $firstName, time() + 3600, '/');
    setcookie('contact_lastName', $lastName, time() + 3600, '/');
    setcookie('contact_email', $email, time() + 3600, '/');
    setcookie('contact_comments', $comments, time() + 3600, '/');

    // Empty first name field
    if (empty($firstName)) {
        header("location: " . $url . "contact.php?error=emptyFirstName");
        exit();
    }

    // Empty email field
    if (empty($email)) {
        header("location: " . $url . "contact.php?error=emptyEmail");
        exit();
    }

    // Empty email field
    if (empty($comments)) {
        header("location: " . $url . "contact.php?error=emptyComments");
        exit();
    }

    // Check if the comments is bigger from 512 characters
    if (strlen($comments) > 512) {
        header("location: " . $url . "contact.php?error=max512");
        exit();
    }

    // Save message
    if (sendContactMsg($firstName, $lastName, $email, $comments)) {
        header("location: " . $url . "contact.php?success=msgSend");
        exit();
    } else {
        header("location: " . $url . "contact.php?error=stmtfail");
        exit();
    }
}