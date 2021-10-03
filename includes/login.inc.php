<?php

// check submit button if click
if (isset($_POST['submit'])) {
    // Get the values from the fields
    $email = $_POST['email'];
    $password = $_POST['password'];
    setcookie('email', $email, time() + 3600, '/');

    // Include database and functions
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    // check if the email is empty
    if (empty($email)) {
        header("location: ../login.php?error=emptyEmailOrUsername");
        exit();
    }

    // check if the email is empty
    if (empty($password)) {
        header("location: ../login.php?error=emptyPassword");
        exit();
    }

    // log in the user
    loginUser($email, $password);
} else {
    // If not set back to sign in form
    header("location: ../signin.php");
    exit();
}
