<?php
// Include the header
include 'includeHTML/header.php';
include 'includes/globalVariables.inc.php';
include 'includes/functions.inc.php';
if (isset($_COOKIE['user_id'])) {
    if (uidExists($_COOKIE['user_id'], $_COOKIE['email'])) {
        $_SESSION['userId'] = $_COOKIE['user_id'];
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['username'] = $_COOKIE['username'];
        header("Location: " . $url . "events.php");
    }
}
?>


<!-- Login Form -->
<div class="container">
    <div class="content">
        <form class="signUp formUser" method="POST" action="includes/login.inc.php">
            <h1>Sign In</h1>
            <div class="row">
                <div class="col-md-6">
                    <!-- <label for="inputEmail" class="form-label">Email</label> -->
                    <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email Or Username" value="<?php if (isset($_COOKIE['email'])) {
                                                                                                                                    echo $_COOKIE['email'];
                                                                                                                                } ?>">
                </div>
                <div class="col-md-6">
                    <!-- <label for="inputPassword" class="form-label">Password</label> -->
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-check">

                <div class="row forgotAndButton">
                    <div class="col-md-6">
                        <input class="form-check-input" type="checkbox" value="" id="rememberMe" name="rememberMe" <?php if (isset($_COOKIE['email'])) { ?> checked <?php } ?>>
                        <label class="form-check-label" for="rememberMe">
                            Remember Me!
                        </label>
                    </div>
                    <div class="col-md-6">
                        <a href="forgotPassword.php" id="forgot">Forgot Password?</a>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-6">
                    <button type="submit" class="btn button" name="submit">Sign In</button>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="col text-center">
                <div class="errors alert alert-danger noneDisplay">Error Message</div>
                <div class="success alert alert-success noneDisplay">Success Message</div>
            </div>
        </div>
    </div>
</div>


<?php
// Include the footer
include_once 'includeHTML/footer.php';
?>