<?php
include 'includeHTML/header.php';
?>


<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="contentforgotPassword col-md-6">
            <form class="forgotPassword formUser" method="POST" action="includes/forgotPassword.inc.php">
                <h1>Forgot Password</h1>
                <div class="row">
                    <div class="col-md-12">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn button" name="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>


<?php
include 'includeHTML/footer.php';
?>