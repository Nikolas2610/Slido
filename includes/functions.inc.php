<?php


// Empty fields
function emptyInputSignup($email, $username, $password, $confirmPassword)
{
    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Valid username
function invalidUid($username)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Invalid email
function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Different passwords
function passwordsMatch($password, $confirmPassword)
{
    if ($password !== $confirmPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Username or email exists
function uidExists($username, $email)
{
    require 'database.inc.php';
    $sql = "SELECT * FROM users WHERE usersName = ? OR usersEmail = ?;";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute([$username, $email])) {
        header("location: ../signUp.php?error=stmtfailed");
        exit();
    }
    // $stmt->execute([$username, $email]);
    $results = $stmt->fetchAll();
    foreach ($results as $result) {
        if ($result->usersName == $username || $result->usersEmail == $email) {
            // User exists END function
            return true;
        }
    }
    return false;
}

// Create user
function createUser($conn, $username, $email, $password)
{
    require 'database.inc.php';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users(usersName, usersEmail, usersPassword) VALUES (:username, :email, :pwd)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email, 'pwd' => $hashedPassword]);
    $conn->close();
    header("location: ../signUp.php?error=none");
    exit();
}

// Empty input login
function emptyInputLogin($email, $password)
{
    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Login User
function loginUser($email, $password)
{
    require 'database.inc.php';
    $sql = "SELECT * FROM users WHERE usersName = ? OR usersEmail = ?;";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute([$email, $email])) {
        header("location: ../login.php?error=stmtfailed");
        echo "<br>stmtfailed";
        exit();
    }
    $results = $stmt->fetchAll();
    foreach ($results as $result) {
        if ($result->usersName == $email || $result->usersEmail == $email) {
            $passwordHashed = $result->usersPassword;
            echo "<br>find email";
            break;
        }
    }
    if ($passwordHashed === null) {
        echo "null";
    }
    $checkPasswords = password_verify($password, $passwordHashed);
    if (!$checkPasswords) {
        header("location: ../login.php?error=wronglogin");
        echo "<br>passwords not match";
        exit();
    } else if ($checkPasswords) {
        session_start();
        $_SESSION['userId'] = $result->usersId;
        $_SESSION['username'] = $result->usersName;
        echo "<br>" . $_SESSION['userId'];
        echo "<br>" . $_SESSION['username'];
        header("location: ../index.php");
        exit();
    }
}
