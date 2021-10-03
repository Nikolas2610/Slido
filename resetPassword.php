<?php
include 'includeHTML/header.php';
include 'includes/globalVariables.inc.php';
// Check if token exists or send the user to index.php
if (isset($_GET['token'])) {
    $_SESSION['token'] = $_GET['token'];
} else {
    header("location: " . $url . "index.php");
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="contentforgotPassword col-md-6">
            <form class="forgotPassword formUser" method="POST" action="includes/resetPassword.inc.php">
                <h1>Reset Password</h1>
                <div class="row">
                    <div class="col-md-12">
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="New Password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn button" name="confirmResetPassword">Confirm Password</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php

// Standart Messages HTML
$begDivErrMsg = '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-danger" role="alert"><p class="text-center1">';
$endDivErrMsg = '</p></div><div class="col"></div></div>';

// Messages Errors
if (isset($_GET['error'])) {
    if ($_GET['error'] == "emptyfields") {
        echo $begDivErrMsg . 'Fill in all fields!' . $endDivErrMsg;
    } else if ($_GET['error'] == "diffPasswords") {
        echo $begDivErrMsg .  "Passwords doesn't match!" . $endDivErrMsg;
    } else if ($_GET['error'] == "invalidemail") {
        echo $begDivErrMsg . 'Choose a valid email!' . $endDivErrMsg;
    } else if ($_GET['error'] == "stmtfailed") {
        echo $begDivErrMsg . 'Something went wrong. Try again!' . $endDivErrMsg;
    } else if ($_GET['error'] == "tokennoexists") {
        echo $begDivErrMsg . 'Token not exists. Request a new password!' . $endDivErrMsg;
    } else if ($_GET['error'] == "tokenexpire") {
        echo $begDivErrMsg . 'Token has expire. Request a new password!' . $endDivErrMsg;
    } else if ($_GET['error'] == "none") {
        echo '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-success" role="alert"><p class="text-center1">
                Your password has been updated. You can sign in with your new password!
                </p></div><div class="col"></div></div>';
    }
}
?>

<?php
include 'includeHTML/footer.php';
?>