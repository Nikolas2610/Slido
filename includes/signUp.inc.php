<?php

// check submit button if click
if (isset($_POST['submit'])) {
    // Get the values from the fields
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $username = $_POST['username'];
    setcookie('sign_up_email', $email, time() + 3600, '/');
    setcookie('sign_up_username', $username, time() + 3600, '/');

    // Include database and functions
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    // Empty Email
    if (empty($email)) {
        header("location: ../signUp.php?error=emptyEmail");
        exit();
    }
    // Empty Username
    if (empty($username)) {
        header("location: ../signUp.php?error=emptyUsername");
        exit();
    }
    // Empty password
    if (empty($password)) {
        header("location: ../signUp.php?error=emptyPassword");
        exit();
    }
    // Empty confirm Password
    if (empty($confirmPassword)) {
        header("location: ../signUp.php?error=emptyConfirmPassword");
        exit();
    }
    // Invalid Username
    if (invalidUid($username)) {
        header("location: ../signUp.php?error=invalidUid");
        exit();
    }
    // Different Passwords
    if (passwordsMatch($password, $confirmPassword) !== false) {
        header("location: ../signUp.php?error=diffPasswords");
        exit();
    }
    // Username or email exists
    if (uidExists($username, $email)) {
        header("location: ../signUp.php?error=usernametaken");
        exit();
    }
    // Invalid email
    if (invalidEmail($email) !== false) {
        header("location: ../signUp.php?error=invalidemail");
        exit();
    }
    // Create user
    createUser($username, $email, $password);
}
// } else {
//     // If not set back to sign up form
//     header("location: ../signUp.php");
// }
