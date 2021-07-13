<?php
include 'header.php';
?>

<div class="container">
    <div class="content">
        <form class="signUp formUser" method="POST" action="includes/signUp.inc.php">
            <h1>Sign Up</h1>
            <div class="row">
                <div class="col-md-6">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email">
                </div>
                <div class="col-md-6">
                    <label for="inputAddress" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="" name="username">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password">
                </div>
                <div class="col-md-6">
                    <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword">
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn button" name="submit">Sign Up</button>
                </div>
            </div>
        </form>

        <?php
        // Messages Errors
        $begDivErrMsg = '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-danger" role="alert"><p class="text-center1">';
        $endDivErrMsg = '</p></div><div class="col"></div></div>';


        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo $begDivErrMsg . 'Fill in all fields!' . $endDivErrMsg;
            } else if ($_GET['error'] == "invalidUid") {
                echo $begDivErrMsg . 'Choose a valid username!' . $endDivErrMsg;
            } else if ($_GET['error'] == "diffPasswords") {
                echo $begDivErrMsg .  "Passwords doesn't match!" . $endDivErrMsg;
            } else if ($_GET['error'] == "usernametaken") {
                echo $begDivErrMsg . 'Choose a unique username or email!' . $endDivErrMsg;
            } else if ($_GET['error'] == "invalidemail") {
                echo $begDivErrMsg . 'Choose a valid email!' . $endDivErrMsg;
            } else if ($_GET['error'] == "stmtfailed") {
                echo $begDivErrMsg . 'Something went wrong, try again!' . $endDivErrMsg;
            } else if ($_GET['error'] == "none") {
                echo '<div class="row"><div class="col"></div><div class="col-md-6 alert alert-success" role="alert"><p class="text-center1">You have signed up!</p></div><div class="col"></div></div>';
            }
        }
        ?>
    </div>
</div>



<?php
include_once 'footer.php';
?>