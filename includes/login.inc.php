<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $password)) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($email, $password);

} else {
    header("location: ../index.php");
    exit();
}