<?php

if (isset($_POST['submit'])) {
    // Include files
    require_once 'functions.inc.php';
    
    // Declare variables
    $username = $_POST['username'];
    $email = $_POST['email'];

    // check if the fields are empty
    if (empty($email)) {
        header("location: ../forgotPassword.php?error=emptyemail");
        exit();
    }
    if (empty($username)) {
        header("location: ../forgotPassword.php?error=emptyusername");
        exit();
    }

    // check email is valid
    if (invalidEmail($email)) {
        echo "invalid email";
        header("location: ../forgotPassword.php?error=invalidmail");
        exit();
    }

    forgotPassword($email, $username);
}
