<?php

session_start();
// require 'database.inc.php';

// $dsn = 'mysql:host=' . $serverName .';dbname='. $dBName;

// $pdo = new PDO($dsn, $dBUsername, $dBPassword);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// if (isset($_POST['submit'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $confirmPassword = $_POST['confirmPassword'];
//     $username = $_POST['username'];
//     // $email = "123@gmail.com";
//     // $password = "123456";
//     // $confirmPassword = "123456";
//     // $username = "Jack";


// // $stmt = $pdo->query('INSERT INTO users(usersName, usersEmail, usersPassword) VALUES (:username, :email, :pwd)')
// $sql = 'INSERT INTO users(usersName, usersEmail, usersPassword) VALUES (:username, :email, :pwd)';
// $stmt = $pdo->prepare($sql);
// $stmt->execute(['username' => $username, 'email' => $email, 'pwd' => $password]);
// }
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $username = $_POST['username'];

    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    // we need function for pass, confirm pass, username
    if (emptyInputSignup($email, $username, $password, $confirmPassword)) {
        header("location: ../signUp.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username)) {
        header("location: ../signUp.php?error=invalidUid");
        exit();
    }

    if (passwordsMatch($password, $confirmPassword) !== false) {
        header("location: ../signUp.php?error=diffPasswords");
        exit();
    }
    if (uidExists($username, $email)) {
        header("location: ../signUp.php?error=usernametaken");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signUp.php?error=invalidemail");
        exit();
    }
    createUser($conn, $username, $email, $password);

} else {
    header("location: ../signUp.php");
}

