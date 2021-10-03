<?php
// Include Header
include 'includeHTML/header.php';
?>

<div class="container">
    <div class="content">
        <form class="signUp formUser" method="POST" action="includes/signUp.inc.php">
            <h1>Sign Up</h1>
            <div class="row">
                <div class="col-md-6">
                    <!-- <label for="inputEmail" class="form-label" >Email</label> -->
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="<?php
                                                                                                                        if (isset($_COOKIE['sign_up_email'])) {
                                                                                                                            echo $_COOKIE['sign_up_email'];
                                                                                                                        }
                                                                                                                        ?>">
                </div>
                <div class="col-md-6">
                    <!-- <label for="inputAddress" class="form-label">Username</label> -->
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?php
                                                                                                                        if (isset($_COOKIE['sign_up_username'])) {
                                                                                                                            echo $_COOKIE['sign_up_username'];
                                                                                                                        }
                                                                                                                        ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- <label for="inputPassword" class="form-label">Password</label> -->
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                </div>
                <div class="col-md-6">
                    <!-- <label for="inputConfirmPassword" class="form-label">Confirm Password</label> -->
                    <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword" placeholder="Confirm Password">
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn button" name="submit">Sign Up</button>
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
// Include Foooter
include_once 'includeHTML/footer.php';
?>