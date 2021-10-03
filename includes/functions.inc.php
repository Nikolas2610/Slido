<?php



// Check for empty fields

use function PHPSTORM_META\type;

function emptyInputSignup($email, $username, $password, $confirmPassword)
{
    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Check if username is valid
function invalidUid($username)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Check email if is valid
function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Check if we have different passwords
function passwordsMatch($password, $confirmPassword)
{
    if ($password !== $confirmPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Check if username or email exists
function uidExists($username, $email)
{
    // Include database connection
    require 'database.inc.php';
    // Query 
    $sql = "SELECT * FROM users WHERE usersName = ? OR usersEmail = ?;";
    $stmt = $pdo->prepare($sql);
    // Check query
    if (!$stmt->execute([$username, $email])) {
        header("location: ../signUp.php?error=stmtfailed");
        exit();
    }
    // Get all the values from database
    $results = $stmt->fetchAll();
    // Check if the user exists in our database
    foreach ($results as $result) {
        if ($result->usersName == $username || $result->usersEmail == $email) {
            // User exists END function
            return true;
        }
    }
    return false;
}

// Create user
function createUser($username, $email, $password)
{
    // Include database connection
    require 'database.inc.php';
    require 'globalVariables.inc.php';
    // $pdo = new PDO($dsn, $dBUsername, $dBPassword);
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //create unique activation code
    $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    // Query to create user
    $sql = 'INSERT INTO users(usersName, usersEmail, usersPassword, activation) VALUES (:username, :email, :pwd, :activation)';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':username' => $username,
        ':email' => $email,
        ':pwd' => $hashedPassword,
        ':activation' => 0
    );
    if ($stmt->execute($params)) {
        // Query to insert the token 
        $activateExpire = date("Y-m-d H:i:s", time() + 60 * 60); //One hour
        $sql = 'INSERT INTO activationkey (username, activationkey, datetime) VALUES (:username, :key, :datetime)';
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':username' => $username,
            ':key' => $activationKey,
            ':datetime' => $activateExpire
        );
        if (!$stmt->execute($params)) {
            header("location: ../signUp.php?error=stmtfailed");
            exit();
        }
        // For Live WEBSITE
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // For Live WEBSITE
        $from = $mymail;
        $to = $email;
        $subject = 'Confirm your Registration';
        $headers = "From:" . $from;
        $message = "Please click on this link to activate your account:\n\n";
        $message .= $url . "activate.php?key=$activationKey";

        if (mail($to, $subject, $message, $headers)) {
            setcookie('sign_up_email', null, -1, '/');
            setcookie('sign_up_username', null, -1, '/');
            header("location: ../signUp.php?success=createUser");
            exit();
        } else {
            header("location: ../signUp.php?error=emailerror");
            exit();
        }
    } else {
        header("location: ../signUp.php?error=stmtfailed");
        exit();
    }
}

// Check if we have empty inputs login
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
    session_start();
    // Include database connection
    require 'database.inc.php';
    // Query
    $sql = "SELECT * FROM users WHERE usersName =:username OR usersEmail = :email;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':username' => $email,
        ':email' => $email
    );
    // Check query
    if (!$stmt->execute($params)) {
        header("location: ../signUp.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == '1') {
        $result = $stmt->fetch();
        // Get the hash password from database
        $passwordHashed = $result->usersPassword;

        // Check the password field with the hash password
        $checkPasswords = password_verify($password, $passwordHashed);
        // For false send the user back to login page
        if (!$checkPasswords) {
            setcookie('email', $email, time() + 3600, '/');
            header("location: ../login.php?error=wronglogin");
            echo "<br>passwords not match";
            exit();
        } else if ($checkPasswords) {
            // For true log the user and get userid and username as session variables
            // echo $result->activation;
            // exit();
            if ($result->activation != 1) {
                header("location: ../login.php?error=notactivated");
                exit();
            } else {

                $_SESSION['userId'] = $result->usersId;
                $_SESSION['username'] = $result->usersName;
                $_SESSION['user_email'] = $result->usersEmail;

                if (!isset($_POST['rememberMe'])) {
                    // Remove cookies
                    setcookie('email', null, -1, '/');
                    setcookie('user_id', null, -1, '/');
                    echo "login without cookies";
                    // REMOVE NOT COOKIE
                    header("location: ../events.php?notcookie");
                    exit();
                } else {
                    // set cookies
                    setcookie('email', $result->usersEmail, time() + 15 * 24 * 60 * 60, '/');
                    setcookie('user_id', $result->usersId, time() + 15 * 24 * 60 * 60, '/');
                    setcookie('username', $result->usersName, time() + 15 * 24 * 60 * 60, '/');
                    header("location: ../events.php");
                    exit();
                }
            }
        }
    } else {
        header("location: ../login.php?error=wrongEmailOrUsername");
        echo "<br>Wrong email or username";
        exit();
    }
}

// Forgot Password - Send link
function forgotPassword($email, $username)
{
    session_start();
    // Include database connection
    require 'database.inc.php';
    require 'globalVariables.inc.php';
    // Query for find the email to database
    $sql = "SELECT * FROM users WHERE usersEmail = :email && usersName =:username;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':email' => $email,
        ':username' => $username
    );
    // Check query
    if (!$stmt->execute($params)) {
        header("location: ../forgotPassword.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == 0) {
        // Email or username not exists
        header("location: ../forgotPassword.php?error=wronginputs");
        exit();
    }
    if ($count == '1') {
        $result = $stmt->fetch();

        // Create Token
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        // Create time for +1 hour
        $dateTime = date("Y/m/d H:i:s", time() + 60 * 60);

        // Query to insert the token
        $sql = 'INSERT INTO forgotpassword(usersId, token, time, status) 
        VALUES (:id, :token, :time, :status);';
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':id' => $result->usersId,
            ':token' => $token,
            ':time' => $dateTime,
            ':status' => 0
        );
        if ($stmt->execute($params)) {
            $conn->close();
            //    send to resetPassword
            // For Live WEBSITE
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            // For Live WEBSITE
            $from = $mymail;
            $to = $email;
            $subject = 'Reset Password';
            $headers = "From:" . $from;

            $message = "Please click on this link to reset your password:\n\n";
            $message .= $url . "resetPassword.php?token=$token";
            if (mail($to, $subject, $message, $headers)) {
                echo "<br>";
                echo "email sent";
                header("location: ../login.php?success=forgotPasswordMailSend");
                exit();
            } else {
                echo "<br>";
                echo "email not sent";
                header("location: ../forgotPassword.php?error=emailerror");
                exit();
            }
        } else {
            header("location: ../forgotPassword.php?error=stmtfailed");
            exit();
        }
    }
}

function emptyResetPassword($password, $confirmPassword)
{
    if (empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function tokenExists($token)
{
    if (empty($token)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function resetPassword($password, $token)
{
    // Include database connection
    require 'database.inc.php';
    // Query
    $sql = "SELECT * FROM forgotpassword WHERE token =:token && status=0;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    // Check query
    if (!$stmt->execute()) {
        echo "Problem with query";
        header("location: ../resetPassword.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == '0') {
        echo "token not exists at database";
        header("location: ../resetPassword.php?error=tokennoexists");
        exit();
    } else {
        $result = $stmt->fetch();
        // Date and Time from token
        $expireDateToken = $result->time;
        // This Date and Time
        $thisTime = date("Y-m-d H:i:s", time());
        // Check if token has expire
        if ($thisTime > $expireDateToken) {
            echo "token has expire";
            header("location: ../login.php?error=tokenexpire");
            exit();
        } else {
            $userid = $result->usersId;
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Query to update the password
            $sql = "UPDATE users SET usersPassword=:pwd WHERE usersId=:id;";
            $stmt = $pdo->prepare($sql);
            $params = array(
                ':id' => $userid,
                ':pwd' => $hashedPassword
            );
            $stmt->bindParam(':id', $params[':id'], PDO::PARAM_INT);
            $stmt->bindParam(':pwd', $params[':pwd'], PDO::PARAM_STR);
            // Check query
            if (!$stmt->execute()) {
                echo "Problem with query";
                header("location: ../resetPassword.php?error=stmtfailed");
                exit();
            }
            $count = $stmt->rowCount();
            if ($count == '0') {
                echo "No results";
                header("location: ../resetPassword.php?error=noresults");
                exit();
            }
            // Query for set status of token 
            $sql = "UPDATE forgotpassword SET status=1 
            WHERE usersId=:id && token=:token";
            $stmt = $pdo->prepare($sql);
            $params = array(
                ':id' => $userid,
                ':token' => $token
            );
            $stmt->bindParam(':id', $params[':id'], PDO::PARAM_INT);
            $stmt->bindParam(':token', $params[':token'], PDO::PARAM_STR);
            // Check query
            if (!$stmt->execute()) {
                echo "Problem with query2";
                header("location: ../resetPassword.php?error=stmtfailed");
                exit();
            }
            $conn->close();
            echo 'Updates Complete';
            header("location: ../login.php?success=passwordchange");
            exit();
        }
    }
}

function emptyUpdateUsername($newUsername, $password)
{
    if (empty($newUsername) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emptyUpdateSessions($userid, $username)
{
    if (empty($userid) || empty($username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Check if username or email exists
function usernameExists($newUsername)
{
    // Include database connection
    require 'database.inc.php';
    // Query 
    $sql = "SELECT * FROM users WHERE usersName =:username;";
    $stmt = $pdo->prepare($sql);
    $params = array(':username' => $newUsername);
    $stmt->bindParam(':username', $params[':username'], PDO::PARAM_STR);
    // Check query
    if (!$stmt->execute()) {
        echo "Problem with query";
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count >= 1) {
        echo "Username exists";
        $conn->close();
        return true;
    } else if ($count == 0) {
        // echo "New username is availbale";
        $conn->close();
        return false;
    }
}

function passwordMatch($password, $username, $userid)
{
    // Include database connection
    require 'database.inc.php';
    // Query 
    $sql = "SELECT * FROM users 
    WHERE usersName =:username && usersId =:id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':username' => $username,
        ':id' => $userid
    );
    // $stmt->bindParam(':pwd', $params[':pwd'], PDO::PARAM_STR);
    $stmt->bindParam(':username', $params[':username'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $params[':id'], PDO::PARAM_STR);
    // Check query
    if (!$stmt->execute()) {
        echo "Problem with query";
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $result = $stmt->fetch();
    // Get the hash password from database
    $passwordHashed = $result->usersPassword;

    // Check the password field with the hash password
    $checkPasswords = password_verify($password, $passwordHashed);

    if ($checkPasswords) {
        // echo "Password match";
        $conn->close();
        return false;
    } else {
        // echo "Password not match";
        $conn->close();
        return true;
    }
}

function updateUsername($username, $userid, $newUsername)
{
    // Include database connection
    require 'database.inc.php';
    // Query to update the username
    $sql = "UPDATE users SET usersName=:newUsersname 
            WHERE usersId=:id && usersName=:username;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':id' => $userid,
        ':username' => $username,
        ':newUsersname' => $newUsername
    );
    // Check query
    if (!$stmt->execute($params)) {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == 1) {
        echo "Username update succesfully!";
        $_SESSION['username'] = $newUsername;

        // Query to update the username at events table
        $sql = "SELECT eventId FROM events WHERE creator=:username;";
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':username' => $username
        );
        // Check query
        if (!$stmt->execute($params)) {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($results);
        // exit();
        if (updateEventsWithNewUsername($newUsername, $results)) {
            // Query to update the username at msg table
            $sql = "SELECT msgId FROM msgs WHERE sender=:username;";
            $stmt = $pdo->prepare($sql);
            $params = array(
                ':username' => $username
            );
            // Check query
            if (!$stmt->execute($params)) {
                header("location: ../profile.php?error=stmtfailed");
                exit();
            }
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (updateMsgsWithNewUsername($newUsername, $results)) {
                header("location: ../profile.php?success=successupdateusername");
                exit();
            } else {
                header("location: ../profile.php?error=stmtfailed");
                exit();
            }
        } else {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
    } else {
        echo "Username update does not succesfully!";
        header("location: ../profile.php?error=notupdateusername");
        exit();
    }

    $count = $stmt->rowCount();
}

function updateEventsWithNewUsername($username, $results)
{
    // Include database connection
    require 'database.inc.php';
    require 'globalVariables.inc.php';
    // Query to update the username at event table
    foreach ($results as $result) {
        $sql = "UPDATE events SET creator=:username 
        WHERE eventId=:event_id;";
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':username' => $username,
            ':event_id' => $result['eventId']
        );
        // Check query
        if (!$stmt->execute($params)) {
            return false;
            exit();
        }
    }
    return true;
}
function updateMsgsWithNewUsername($username, $results)
{
    // Include database connection
    require 'database.inc.php';
    require 'globalVariables.inc.php';
    // Query to update the username at event table
    foreach ($results as $result) {
        $sql = "UPDATE msgs SET sender=:username 
        WHERE msgId=:msg_id;";
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':username' => $username,
            ':msg_id' => $result['msgId']
        );
        // Check query
        if (!$stmt->execute($params)) {
            return false;
            exit();
        }
    }
    return true;
}

function emptyUpdatePasswords($oldPassword, $newPassword, $confirmPassword)
{
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function updatePassword($username, $userid, $newPassword)
{
    // Include database connection
    require 'database.inc.php';
    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    // Query to update the username
    $sql = "UPDATE users SET usersPassword=:newPassword 
            WHERE usersId=:id && usersName=:username;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':id' => $userid,
        ':username' => $username,
        ':newPassword' => $hashedPassword
    );
    print_r($params);
    $stmt->bindParam(':id', $params[':id'], PDO::PARAM_INT);
    $stmt->bindParam(':username', $params[':username'], PDO::PARAM_STR);
    $stmt->bindParam(':newPassword', $params[':newPassword'], PDO::PARAM_STR);
    // Check query
    if (!$stmt->execute()) {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == 1) {
        echo "Password update succesfully!";
        header("location: ../profile.php?error=successupdatepassword");
        exit();
    } else {
        echo "Password update does not succesfully!";
        header("location: ../profile.php?error=notupdatepassword");
        exit();
    }
}

function createEvent($eventname, $invitePeople, $startDate, $endDate, $username, $privateRoom, $roomPassword, $duplicateEvent, $reviewQa)
{
    include 'database.inc.php';
    //create unique activation code
    $temp = true;
    while ($temp) {
        $randomEventId = mt_rand(100000, 999999);
        // Query to check the event publish ID
        $sql = "SELECT * FROM events WHERE publishId =:publishId;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':publishId', $randomEventId, PDO::PARAM_INT);
        // Check query
        if (!$stmt->execute()) {
            header("location: ../signUp.php?error=stmtfailed1");
            exit();
        }
        $count = $stmt->rowCount();
        if ($count == 0) {
            $temp = false;
        }
    }
    // Hash the password
    if ($duplicateEvent == 1) {
        $hashedRoomPassword = $roomPassword;
    } elseif ($duplicateEvent == 0) {
        if ($privateRoom) {
            $hashedRoomPassword = password_hash($roomPassword, PASSWORD_DEFAULT);
        } else {
            $hashedRoomPassword = 0;
        }
    }

    // Query to insert the event
    $sql = 'INSERT INTO events (publishId, eventName, creator, startDate, endDate, eventStatus, eventPassword, reviewQa) 
    VALUES (:publishId, :eventName, :creator, :startDate, :endDate, :eventStatus, :eventPassword, :reviewQa);';
    $stmt = $pdo->prepare($sql);

    $params = array(
        ':publishId' => $randomEventId,
        ':eventName' => $eventname,
        ':creator' => $username,
        ':startDate' => $startDate,
        ':endDate' => $endDate,
        ':eventStatus' => $privateRoom,
        ':eventPassword' => $hashedRoomPassword,
        ':reviewQa' => $reviewQa
    );
    if ($stmt->execute($params)) {
        $conn->close();
        // Back to events page
        return $randomEventId;
        exit();
    } else {
        $conn->close();
        return false;
        exit();
    }
}

// function changeTime($date)
// {
//     list($day, $month, $year) = explode('/', $date);
//     $newDate = sprintf("%s-%s-%s", $year, $month, $day);
//     return $newDate;
// }

function changeTimeDashForSql($date)
{
    list($day, $month, $year) = explode('-', $date);
    $newDate = sprintf("%s-%s-%s", $year, $month, $day);
    return $newDate;
}

function changeTimeDashForHTML($date)
{
    list($year, $month, $day) = explode('-', $date);
    $newDate = sprintf("%s-%s-%s", $day, $month, $year);
    return $newDate;
}

function changeDateFormatTo_dMY($date)
{
    return date("d M Y", strtotime($date));
}

function pollkind($kind)
{
    switch ($kind) {
        case "MP":
            return "Multiple Choice";
            break;
        case "QZ":
            return "Quiz";
            break;
        case "RK":
            return "Rank";
            break;
        case "RG":
            return "Rating";
            break;
    }
}

function codePollKind($kind)
{
    switch ($kind) {
        case 1:
            return "MP";
            break;
        case 2:
            return "QZ";
            break;
        case 3:
            return "RK";
            break;
        case 4:
            return "RG";
            break;
    }
}

function setPollStatusOff($eventId)
{
    include 'database.inc.php';
    // Query
    $sql = 'UPDATE polls SET status=:status WHERE eventId =:eventid;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':status' => 'off',
        ':eventid' => $eventId
    );
    $stmt->bindParam(':status', $params[':status'], PDO::PARAM_STR);
    $stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
    if (!$stmt->execute()) {
        $conn->close();
        echo "Problem with query";
        // header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $conn->close();
}

function emptyCreatePoll($question, $answer1, $answer2)
{
    if (empty($question) || empty($answer1) || empty($answer2)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createPoll($eventId, $question, $answer, $countAnswers, $time, $pollKind, $status, $correctAnswers)
{
    include 'database.inc.php';
    include 'globalVariables.inc.php';
    if ($status == 'live') {
        setPollStatusOff($eventId);
    }
    // Query to insert the event
    $sql = 'INSERT INTO polls (eventId, question, answers, correctAnswers, peopleAnswers, dateCreate, pollKind, status) 
    VALUES (:eventId, :question, :answers, :correctAnswers,:peopleAnswers, :dateCreate, :pollKind, :status);';
    $stmt = $pdo->prepare($sql);

    $params = array(
        ':eventId' => $eventId,
        ':question' => $question,
        ':answers' => $answer,
        ':correctAnswers' => $correctAnswers,
        ':peopleAnswers' => $countAnswers,
        ':dateCreate' => $time,
        ':pollKind' => $pollKind,
        ':status' => $status
    );
    if (!$stmt->execute($params)) {
        return false;
        // header("location: ../polls.php?poll=list&error=stmtfailed");
        exit();
    } else {
        if ($status == 'live') {
            $last_poll_id = $pdo->lastInsertId();
            if (!setLivePoll($eventId, $last_poll_id)) {
                return false;
                // header("location: ../polls.php?poll=list&error=stmtfailed");
                exit();
            }
        }
        // Back to poll page
        return true;
        // header("location: " . $url . "polls.php?poll=list");
        exit();
    }
}

function findPollIcon($pollKind)
{
    switch ($pollKind) {
        case "MP":
            return '<i class="bi bi-list-ul icons-size"></i>';
            break;
        case "QZ":
            return '<i class="bi bi-trophy icons-size"></i>';
            break;
        case "RG":
            return '<i class="bi bi-star-fill icons-size"></i>';
            break;
        case "RK":
            return '<i class="bi bi-arrow-down-up icons-size"></i>';
            break;
    }
}

function getDetailsEvent($username, $event_id)
{
    include 'database.inc.php';
    // Query
    $sql = 'SELECT * FROM events WHERE creator=:username && publishId=:eventid LIMIT 1;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':username' => $username,
        ':eventid' => $event_id
    );
    $stmt->bindParam(':username', $params[':username'], PDO::PARAM_STR);
    $stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
    if (!$stmt->execute()) {
        echo "Problem with query";
        // header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();



    if ($count == 1) {
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        return $event;
    } else {
        $event = false;
        return $event;
    }
    // echo gettype($event);
    exit();
}

function eventPasswordMatch($username, $eventid, $password)
{
    require 'database.inc.php';
    // Query 
    $sql = "SELECT * FROM events 
       WHERE creator =:username && publishId =:id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':username' => $username,
        ':id' => $eventid
    );
    // Check query
    if (!$stmt->execute($params)) {
        echo "Problem with query";
        header("location: ../events.php?error=stmtfailed");
        exit();
    }
    $result = $stmt->fetch();
    // Get the hash password from database
    $passwordHashed = $result->eventPassword;

    // Check the password field with the hash password
    $checkPasswords = password_verify($password, $passwordHashed);

    if ($checkPasswords) {
        // echo "Password match";
        $conn->close();
        return true;
    } else {
        // echo "Password not match";
        $conn->close();
        return false;
    }
}

function updateEvent($eventid, $eventname, $invitePeople, $startDate, $endDate, $username, $privateRoom, $roomPassword, $reviewQa)
{
    // Include database connection
    require 'database.inc.php';
    require 'globalVariables.inc.php';
    // Hash the password
    $hashedPassword = password_hash($roomPassword, PASSWORD_DEFAULT);
    // Query to update the username
    $sql = "UPDATE events SET eventName=:eventname, startDate=:startDate, endDate=:endDate, eventStatus=:status, eventPassword=:password, reviewQa=:reviewQa
            WHERE publishId=:eventid;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':eventname' => $eventname,
        ':startDate' => $startDate,
        ':endDate' => $endDate,
        ':status' => $privateRoom,
        ':password' => $hashedPassword,
        ':eventid' => $eventid,
        ':reviewQa' => $reviewQa
    );
    // Check query
    if (!$stmt->execute($params)) {
        echo "Problem with query";
        // header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == 1) {
        echo "Event update succesfully!";
        $_SESSION['event_name'] = $eventname;
        // Unset the password match
        unset($_SESSION['pwd_match']);
        header("location: " . $url . "events.php?success=successupdatevent");
        exit();
    } else {
        echo "Event update does not succesfully!";
        header("location: " . $url . "events.php?error=notupdate");
        exit();
    }
}

function joinEvent($event_id)
{
    require 'database.inc.php';
    require 'globalVariables.inc.php';
    // Query to find the event 
    $sql = "SELECT * FROM events 
       WHERE publishId =:id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':id' => $event_id
    );
    // Check query
    if (!$stmt->execute($params)) {
        header("location: " . $url . "index.php?error=stmtfailed");
        exit();
    }
    $count = $stmt->rowCount();


    if ($count == '0') {
        echo "No results";
        // Destroy Session Variables
        unset($_SESSION['guest_event_id']);
        unset($_SESSION['guest_event_name']);
        header("location: " . $url . "index.php?error=noevent");
        exit();
    }
    $result = $stmt->fetch();
    $_SESSION['guest_event_id'] = $result->publishId;
    $_SESSION['guest_event_name'] = $result->eventName;
    $_SESSION['reviewQa'] = $result->reviewQa;
    if ($result->eventStatus == 1) {
        // When event is private goes to check password event
        header("location: " . $url . "guestPassword.php");
        echo "private room";
        exit();
    }
    header("location: " . $url . "event.php?event=" . $result->publishId . "&room=qa");
    exit();
}

function eventGuestPasswordMatch($eventid, $password)
{
    require 'database.inc.php';
    // Query 
    $sql = "SELECT * FROM events 
       WHERE publishId =:id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':id' => $eventid
    );
    $stmt->bindParam(':id', $params[':id'], PDO::PARAM_STR);
    // Check query
    if (!$stmt->execute()) {
        echo "Problem with query";
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $result = $stmt->fetch();
    // Get the hash password from database
    $passwordHashed = $result->eventPassword;

    // Check the password field with the hash password
    $checkPasswords = password_verify($password, $passwordHashed);

    if ($checkPasswords) {
        // echo "Password match";
        $conn->close();
        return true;
    } else {
        // echo "Password not match";
        $conn->close();
        return false;
    }
}

function getAnswerPercentage($answer, $allAnswers)
{
    if ($allAnswers == 0) {
        return 0;
    } else {
        $average = ($answer / $allAnswers) * 100;
        return round($average, 2);
    }
}

function getCorrectAnswer($correctAnswerString)
{
    $correctAnswerIntArray = array_map('intval', explode('/', $correctAnswerString));
    for ($i = 0; $i < sizeof($correctAnswerIntArray); $i++) {
        if ($correctAnswerIntArray[$i] == 1) {
            return $i;
        }
    }
}

function changeStringArrToIntArr($stringArray)
{
    // peopleAnswers change to integer array and after the sum of the values of the array
    $integerArray = array_map('intval', explode('/', $stringArray));
    return $integerArray;
}

function removeLikeToUser($array, $msg_id)
{
    $newArray = array();
    for ($i = 0; $i < sizeof($array); $i++) {
        if ($array[$i] == $msg_id) {
            continue;
        } else {
            array_push($newArray, $array[$i]);
        }
    }
    return $newArray;
}

function changeIntArrToString($integerArray)
{
    $string = strval($integerArray[0]);
    for ($i = 1; $i < sizeof($integerArray); $i++) {
        $string .= '/ ' . strval($integerArray[$i]);
    }
    return $string;
}

function duplicatePolls($eventId, $newEventId)
{
    include 'database.inc.php';
    // Query
    $sql = 'SELECT * FROM polls WHERE eventId=:eventid ORDER BY dateCreate DESC;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':eventid' => $eventId
    );
    $stmt->bindParam(':eventid', $params[':eventid'], PDO::PARAM_STR);
    if (!$stmt->execute()) {
        // Problem with query
        echo 0;
        exit();
    }
    // $counts = $stmt->rowCount();
    // echo $counts;
    // exit();
    $results = $stmt->fetchAll();

    foreach ($results as $result) {
        $peopleAnswers = emptyPollAnswersForDuplicatePoll($result->correctAnswers);
        $time = date("Y-m-d H:i:s", time());

        // Query to insert the event
        $sql = 'INSERT INTO polls (eventId, question, answers, correctAnswers, peopleAnswers, dateCreate, pollKind, status) 
        VALUES (:eventId, :question, :answers, :correctAnswers,:peopleAnswers, :dateCreate, :pollKind, :status);';
        $stmt = $pdo->prepare($sql);

        $params = array(
            ':eventId' => $newEventId,
            ':question' => $result->question,
            ':answers' => $result->answers,
            ':correctAnswers' => $result->correctAnswers,
            ':peopleAnswers' => $peopleAnswers,
            ':dateCreate' => $time,
            ':pollKind' => $result->pollKind,
            ':status' => 'off'
        );
        $stmt->bindParam(":eventId", $params[':eventId'], PDO::PARAM_STR);
        $stmt->bindParam(":question", $params[':question'], PDO::PARAM_STR);
        $stmt->bindParam(":answers", $params[':answers'], PDO::PARAM_STR);
        $stmt->bindParam(":correctAnswers", $params[':correctAnswers'], PDO::PARAM_STR);
        $stmt->bindParam(":peopleAnswers", $params[':peopleAnswers'], PDO::PARAM_STR);
        $stmt->bindParam(":dateCreate", $params[':dateCreate'], PDO::PARAM_STR);
        $stmt->bindParam(":pollKind", $params[':pollKind'], PDO::PARAM_STR);
        $stmt->bindParam(":status", $params[':status'], PDO::PARAM_STR);
        if (!$stmt->execute()) {
            echo "Problem Query";
            return 0;
        }
    }
    return 1;
}

function emptyPollAnswersForDuplicatePoll($answers)
{
    $answersArray = explode('/', $answers);
    $newAnswers = '0';
    for ($i = 1; $i < sizeof($answersArray); $i++) {
        $newAnswers .= '/ 0';
    }
    return $newAnswers;
}

function getRandomCookieId()
{
    include 'database.inc.php';
    include 'globalVariables.inc.php';
    $temp = true;
    while ($temp) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-/_+';
        $randomString = '';
        $n = rand(6, 10);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        // Query to check the event publish ID
        $sql = "SELECT * FROM guests WHERE usersId =:randomString;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':randomString', $randomString, PDO::PARAM_STR);
        // Check query
        if (!$stmt->execute()) {
            header("location: " . $url . "index.php?error=stmtfailed");
            exit();
        }
        $count = $stmt->rowCount();
        if ($count == 0) {
            $temp = false;
        }
    }
    return $randomString;
}


function findGuest($userId, $eventId)
{
    include 'database.inc.php';
    include 'globalVariables.inc.php';
    // Query
    $sql = 'SELECT * FROM guests WHERE usersId=:user_id && eventId=:event_id;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':user_id' => $userId,
        ':event_id' => $eventId,
    );
    if (!$stmt->execute($params)) {
        // Problem with query
        // header("location: " . $url . "index.php?error=notuserfind");
        exit();
    }
    $count = $stmt->rowCount();
    if ($count == 0) {
        // False
        return 0;
    } else {
        // True
        return 1;
    }
}

function createGuest($userId, $eventId)
{
    include 'database.inc.php';
    include 'globalVariables.inc.php';
    // Query to insert the guest to guest table
    $sql = 'INSERT INTO guests (usersId, eventId) 
            VALUES (:usersId, :eventId);';
    $stmt = $pdo->prepare($sql);

    $params = array(
        ':usersId' => $userId,
        ':eventId' => $eventId
    );

    if (!$stmt->execute($params)) {
        // Problem with query
        // header("location: " . $url . "index.php?error=notcreateuser");
        exit();
    }
}

function sendInviteByEmail($mail, $username, $inviteUrl)
{
    include 'globalVariables.inc.php';
    // For Live WEBSITE
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    // For Live WEBSITE
    $from = $mymail;
    $subject = 'Join Event';
    $headers = "From:" . $from;
    $message = "The user " . $username . " has invite you to Virtual Room.\n\n Please click on this link to join the event:\n\n";
    $message .= $inviteUrl;
    for ($i = 0; $i < sizeof($mail); $i++) {
        if (!mail($mail[$i], $subject, $message, 'From:' . $headers)) {
            header("location: " . $url . "event.php?error=sendEmailError");
            exit();
        }
    }
    // echo $url;
    header("location: " . $url . "events.php?success=invitePeopleByEmail");
    return;
}

function sendMsg($event_id, $username, $msgContent, $status, $user_id)
{
    // Include files
    include 'database.inc.php';
    include 'globalVariables.inc.php';

    // Declare variables
    $likes = 0;
    $reply = -1;
    $highlight = 0;
    $time = date("Y-m-d H:i:s", time());

    // Query to insert the event
    $sql = 'INSERT INTO msgs (eventId, sender, usersId, reply, dateCreate, msgContent, likes, status, highlight) 
    VALUES (:eventId, :username, :userId, :reply, :dateCreate, :msgContent, :likes, :status, :highlight);';
    $stmt = $pdo->prepare($sql);

    $params = array(
        ':eventId' => $event_id,
        ':username' => $username,
        ':userId' => $user_id,
        ':reply' => $reply,
        ':dateCreate' => $time,
        ':msgContent' => $msgContent,
        ':likes' => $likes,
        ':status' => $status,
        ':highlight' => $highlight
    );

    if (!$stmt->execute($params)) {
        // Query Problem
        // header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
        return 0;
        exit();
    } else {
        // echo "SQL DONE";
        if ($status == 1) {
            // header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&success=msgsend");
            return 1;
            exit();
        } else {
            // header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&success=msgsendreview");
            return 2;
            exit();
        }
    }
}

function highlightFirstElement($results)
{
    for ($i = 0; $i < sizeof($results); $i++) {
        if ($results[$i]['highlight']) {
            $tempArr = array('0' => $results[$i]);
            $index = $i;
            break;
        }
    }
    if (empty($index)) {
        return $results;
    }
    for ($i = 0; $i < sizeof($results); $i++) {
        if ($i == $index) {
            continue;
        } else {
            array_push($tempArr, $results[$i]);
        }
    }
    return $tempArr;
}

function editMsg($msgId, $msgContent, $status)
{
    include 'database.inc.php';

    // Query to update the username
    $sql = "UPDATE msgs SET msgContent=:msg, status=:status WHERE msgId=:msg_id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':msg' => $msgContent,
        ':msg_id' => $msgId,
        ':status' => $status
    );
    if (!$stmt->execute($params)) {
        // Query Problem
        // header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
        return false;
        exit();
    }
    // Everything Ok
    // header("location: " . $url . "event.php?event=" . $event_id . "&room=qa");
    return true;
    exit();
}

function replyMsg($event_id, $username, $msgContent, $status, $user_id, $msgId)
{
    // Include files
    include 'database.inc.php';
    include 'globalVariables.inc.php';

    // Declare variables
    $likes = 0;
    $reply = -1;
    $highlight = 0;
    $time = date("Y-m-d H:i:s", time());

    // Query to insert the event
    $sql = 'INSERT INTO msgs (eventId, sender, usersId, reply, dateCreate, msgContent, likes, status, highlight) 
    VALUES (:eventId, :username, :userId, :reply, :dateCreate, :msgContent, :likes, :status, :highlight);';
    $stmt = $pdo->prepare($sql);

    $params = array(
        ':eventId' => $event_id,
        ':username' => $username,
        ':userId' => $user_id,
        ':reply' => $reply,
        ':dateCreate' => $time,
        ':msgContent' => $msgContent,
        ':likes' => $likes,
        ':status' => $status,
        ':highlight' => $highlight
    );

    if (!$stmt->execute($params)) {
        // Query Problem
        // header("location: " . $url . "qa.php?error=stmtfailed");
        return false;
        exit();
    } else {
        // echo "SQL DONE";
        // Query to update the username
        $last_id = $pdo->lastInsertId();
        $sql = "UPDATE msgs SET reply=:reply_id WHERE msgId=:msg_id;";
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':reply_id' => $last_id,
            ':msg_id' => $msgId
        );
        if (!$stmt->execute($params)) {
            // Query Problem
            // header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
            exit();
        }
        // Back to poll page
        return true;
        exit();
    }
}

function updateGuestNickname($nickname, $event_id, $user_id)
{
    // Include files
    include 'database.inc.php';
    include 'globalVariables.inc.php';

    // Query to update nickname
    $sql = "UPDATE guests SET username=:nickname WHERE eventId=:event_id && usersId=:userId;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':nickname' => $nickname,
        ':event_id' => $event_id,
        ':userId' => $user_id
    );
    if (!$stmt->execute($params)) {
        // Query Problem
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
        return false;
        exit();
    }
    // Query to update nickname at msgs tables
    $sql = "UPDATE msgs SET sender=:nickname WHERE eventId=:event_id && usersId=:userId;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':nickname' => $nickname,
        ':event_id' => $event_id,
        ':userId' => $user_id
    );
    if (!$stmt->execute($params)) {
        // Query Problem
        header("location: " . $url . "event.php?event=" . $event_id . "&room=qa&error=stmtfailed");
        return false;
        exit();
    }
    return true;
}

function updatePoll($poll_id, $question, $answer, $correctAnswers, $peopleAnswers)
{
    // Include files
    include 'database.inc.php';
    include 'globalVariables.inc.php';

    // Query to update nickname
    $sql = "UPDATE polls SET question=:question, answers=:answer, correctAnswers=:correctAnswers, peopleAnswers=:peopleAnswers
     WHERE pollId=:poll_id;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':question' => $question,
        ':answer' => $answer,
        ':correctAnswers' => $correctAnswers,
        ':poll_id' => $poll_id,
        ':peopleAnswers' => $peopleAnswers
    );
    if (!$stmt->execute($params)) {
        // Query Problem
        return false;
        exit();
    }
    return true;
}

function setLivePoll($eventId, $pollId)
{
    // Include Files
    include 'globalVariables.inc.php';
    include 'database.inc.php';
    // Query to update livepoll
    $sql = 'UPDATE livepolls SET pollId=:pollId WHERE eventId =:eventid;';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':eventid' => $eventId,
        ':pollId' => $pollId
    );
    if (!$stmt->execute($params)) {
        return 0;
        // header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $counts = $stmt->rowCount();
    if ($counts == 0) {
        // Query to insert the live poll
        $sql = 'INSERT INTO livepolls (eventid, pollId) 
    VALUES (:eventid, :pollId);';
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':eventid' => $eventId,
            ':pollId' => $pollId
        );
        if (!$stmt->execute($params)) {
            return 0;
            // header("location: ../profile.php?error=stmtfailed");
            exit();
        }
    }
    return 1;
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function convertStringToArray($formData)
{
    $tempArray = array();
    $finalArray = array();
    for ($i = 0; $i < sizeof($formData); $i++) {
        $tempArray = explode('=', $formData[$i]);
        $finalArray[$tempArray[0]] = $tempArray[1];
    }
    return $finalArray;
}

function stringSetSpaces($question)
{
    $a = 0;
    $temp = '';
    while ($a <= strlen($question) - 1) {
        if ($question[$a] == '%') {
            $temp .= ' ';
            $a += 3;
        } else {
            $temp .= $question[$a];
            $a++;
        }
    }
    return $temp;
}

function sendContactMsg($firstName, $lastName, $email, $comments)
{
    // Include database connection
    require 'database.inc.php';

    // Query to create comment at contact table
    $sql = 'INSERT INTO contact(firstName, lastName, email, comments) VALUES (:firstName, :lastName, :email, :comments)';
    $stmt = $pdo->prepare($sql);
    $params = array(
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':email' => $email,
        ':comments' => $comments
    );
    if (!$stmt->execute($params)) {
        // stmt fail
        return false;
    }
    // Remove cookies
    setcookie('contact_firstName', null, -1, '/');
    setcookie('contact_lastName', null, -1, '/');
    setcookie('contact_email', null, -1, '/');
    setcookie('contact_comments', null, -1, '/');
    // Everything ok
    return true;
}
