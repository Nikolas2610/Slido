<?php
session_start();
// check submit button if click
if (isset($_POST['updateUsername'])) {
    // Include functions
    require_once 'functions.inc.php';
    // Get the values from the fields and session variables
    $newUsername = $_POST['newUsername'];
    $password = $_POST['password'];
    $userid = $_SESSION['userId'];
    $username = $_SESSION['username'];

    // Empty Username
    if (empty($newUsername)) {
        header("location: ../profile.php?error=emptyUsername");
        exit();
    }
    // Empty Password
    if (empty($password)) {
        header("location: ../profile.php?error=emptyPassword");
        exit();
    }
    // Empty Session variables
    if (emptyUpdateSessions($userid, $username)) {
        header("location: ../profile.php?error=nosession");
        exit();
    }
    // Invalid Username
    if (invalidUid($newUsername)) {
        header("location: ../profile.php?error=invalidUid");
        exit();
    }

    // Username or email exists
    if (usernameExists($newUsername)) {
        header("location: ../profile.php?error=usernametaken");
        echo "username exists";
        exit();
    } 
    // Password match with database to the usernameExists
    if (passwordMatch($password, $username, $userid)) {
        header("location: ../profile.php?error=wrongpassword");
        // echo "Wrong Password";
        exit();
    } 
    // Update username (id, password, newusername)
    updateUsername($username, $userid, $newUsername);
    exit();
}

if (isset($_POST['updatePassword'])) {
    // Include functions
    require_once 'functions.inc.php';
    // Get the values from the fields and session variables
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $userid = $_SESSION['userId'];
    $username = $_SESSION['username'];

// Empty old password
    if (empty($oldPassword)) {
        header("location: ../profile.php?error=emptyOldPassword");
        exit();
    }
    // Empty new password
    if (empty($newPassword)) {
        header("location: ../profile.php?error=emptyNewPassword");
        exit();
    }
    // Empty confirm password
    if (empty($confirmPassword)) {
        header("location: ../profile.php?error=emptyConfirmPassword");
        exit();
    }

    // Empty Session variables
    if (emptyUpdateSessions($userid, $username)) {
        header("location: ../profile.php?error=nosession");
        exit();
    }

    // Password match with database to the usernameExists
    if (passwordMatch($oldPassword, $username, $userid)) {
        header("location: ../profile.php?error=wrongpassword");
        // echo "Wrong Password";
        exit();
    } 

    // Check if new password with confirm password is match
    if (passwordsMatch($newPassword, $confirmPassword)) {
        header("location: ../profile.php?error=diffPasswords");
        // echo "Wrong Password";
        exit();
    }

    // Update username (id, password, newusername)
    updatePassword($username, $userid, $newPassword);
    exit();
}
