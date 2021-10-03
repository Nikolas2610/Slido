<?php
// Includes
include_once 'includeHTML/header.php';
require 'includes/database.inc.php';
require 'includes/globalVariables.inc.php';

if (!isset($_GET['key'])) {
    echo '<div class="alert alert-danger">There was an error. Please click on the activation you received by email.</div>';
    header("location: " . $url . "signUp.php?error=nokey");
    exit();
}

$key = $_GET['key'];
$sql = 'SELECT * FROM activationkey WHERE activationkey=:key;';
$params = array(
    ':key' => $key
);
$stmt = $pdo->prepare($sql);
if (!$stmt->execute($params)) {
    header("location: " . $url . "signUp.php?error=stmtfailed");
    exit();
}
$count = $stmt->rowCount();
if ($count == 0) {
    // Token not exists
    header("location: " . $url . "signUp.php?error=notoken");
    exit();
}
if ($count == 1) {
    $result = $stmt->fetch();
    $username = $result->username;
    $curentTime = date("Y-m-d H:i:s", time());
    if ($curentTime < $result->datetime) {
        // Query
        $sql = 'UPDATE users SET activation=1 WHERE usersName=:username';
        $stmt = $pdo->prepare($sql);
        $params = array(
            ':username' => $result->username
        );
        if (!$stmt->execute($params)) {
            header("location: " . $url . "signUp.php?error=stmtfailed");
            exit();
        } else {
            // Activate email and back to login page
            header("location: " . $url . "login.php?success=activateemail");
            exit();
        }
    } else {
        // Token Expire
        // Query the event
        $sql = 'DELETE FROM users WHERE usersName=:username;';
        $stmt = $pdo->prepare($sql);
        $param = array(
            ':username' => $username
        );
        if (!$stmt->execute($param)) {
            echo "Problem with query";
            header("location: " . $url . "events.php?error=stmtfail");
            exit();
        }
        header("location: ../signUp.php?error=tokenexpire");
        exit();
    }
}


exit();

$count = $stmt->rowCount();

if ($count == '0') {
    $begDivErrMsg = '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-danger" role="alert"><p class="text-center1">';
    $endDivErrMsg = '</p></div><div class="col"></div></div>';
    echo $begDivErrMsg . 'Your account could not be activated. Please try again later!' . $endDivErrMsg;
} else {
    echo '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-success" role="alert"><p class="text-center1">
            Your account has been activated.
            </p></div><div class="col"></div></div>';
    // echo '<a href="index.php" type="button" class="btn-lg btn-success">Log in</a>';
}
$conn->close();

// header("location: ../signUp.php?error=activate");
// exit();

// if ($stmt->fetch(PDO::FETCH_BOUND)) {
//     $stmt = $pdo->prepare('UPDATE users SET activation="activated" WHERE activation=:key');
//     $stmt->bindParam(':key', $key, PDO::PARAM_STR);
//     if (!$stmt->execute()) {
//         header("location: ../signUp.php?error=stmtfailed");
//         exit();
//     } 
//     echo "success";
// }
?>


<?php
// Include the footer
include_once 'includeHTML/footer.php';
?>