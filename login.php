<?php
include 'header.php';
?>

<div class="container">
    <div class="content">
        <form class="signUp formUser" method="POST" action="includes/login.inc.php">
            <h1>Sign In</h1>
            <div class="row">
                <div class="col-md-6">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn button" name="submit">Sign In</button>
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
            } else if ($_GET['error'] == "wronglogin") {
                echo $begDivErrMsg . 'Incorrect login information!' . $endDivErrMsg;
            }
        }
        ?>
    </div>
</div>


<?php
include_once 'footer.php';
?>