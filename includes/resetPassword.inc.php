<?php
session_start();
include 'functions.inc.php';

if (isset($_POST['confirmResetPassword'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $token = $_SESSION['token'];

    // check if token exists
    if (tokenExists($token)) {
        header("location: ../resetPassword.php?error=tokennoexists");
        echo "no token";
        exit();
    }


    // check if the fields are empty
    if (emptyResetPassword($password, $confirmPassword)) {
        header("location: ../resetPassword.php?error=emptyfields&token=$token");
        echo "no passwords";
        exit();
    }

    // check email is valid
    if (passwordsMatch($password, $confirmPassword)) {
        header("location: ../resetPassword.php?error=diffPasswords&token=$token");
        echo "Passwords does not match";
        exit();
    }

    resetPassword($password, $token);
}
