<?php
include 'includeHTML/header.php';
// include 'includeHTML/header2.php';
include 'includes/globalVariables.inc.php';
if (empty($_SESSION['userId'])) {
    header("location: " . $url . "index.php");
}
if (!isset($_SESSION['user_email'])) {
    $_SESSION['user_email'] = $_COOKIE['email'];
}
?>
<!-- rounded-pill  -->
<div class="container-lg">
    <div class="row p-3 rounded-pill border-bottom mb-5 mt-3">
        <div class="col">
            <h3>Edit Profile</h3>
        </div>
    </div>

    <div class="row p-2 mt-5 mb-5 align-items-center justify-content-center"></div>

    <div class="row p-2 mt-5 align-items-center justify-content-center rounded-pill border hoverRow">
        <div class="col text-center editprofile">Username: <?php echo $_SESSION['username'] ?></div>
    </div>
    <div class="row p-2 mt-5 align-items-center justify-content-center rounded-pill border hoverRow">
        <div class="col text-center editprofile">Email: <?php echo $_SESSION['user_email'] ?></div>
    </div>
    <div class="row p-2 mt-5 align-items-center justify-content-center rounded-pill border hoverRow">
        <div class="col text-center editprofile">Password: *******</div>
    </div>

    <div class="row p-2 mt-5 mb-5 align-items-center justify-content-center"></div>

    <div class="row p-2 mt-3 align-items-center justify-content-center rounded-pill border-top">
        <div class="col-6 text-end">
            <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#changeUsername" data-bs-whatever="@mdo">Change Username</button>
        </div>
        <div class="col-6 text-start">
            <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#changePassword" data-bs-whatever="@fat">Change Password</button>
        </div>
    </div>

    <!-- Modal Section -->
    <!-- Modal Buttons -->



</div>
<!-- Change Username Modal -->
<div class="modal fade text-dark bg-gradient" id="changeUsername" tabindex="-1" aria-labelledby="changeUsernameLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-gradient">
            <div class="modal-header">
                <h5 class="modal-title" id="changeUsernameLabel">Change Username</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="includes/profile.inc.php">
                    <div class="mb-3">
                        <!-- <label for="recipient-name" class="col-form-label">Username:</label> -->
                        <input type="text" class="form-control" id="newUsername" placeholder="New Username" name="newUsername">
                    </div>
                    <div class="mb-3">
                        <!-- <label for="message-text" class="col-form-label">Message:</label> -->
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        <!-- <textarea class="form-control" id="message-text"></textarea> -->
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="updateUsername">Update Username</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade text-dark bg-gradient" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-gradient">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="includes/profile.inc.php">
                    <div class="mb-3">
                        <!-- <label for="recipient-name" class="col-form-label">Username:</label> -->
                        <input type="password" class="form-control" id="oldPassword" placeholder="Old Password" name="oldPassword">
                    </div>
                    <div class="mb-3">
                        <!-- <label for="message-text" class="col-form-label">Message:</label> -->
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password" name="newPassword">
                        <!-- <textarea class="form-control" id="message-text"></textarea> -->
                    </div>
                    <div class="mb-3">
                        <!-- <label for="message-text" class="col-form-label">Message:</label> -->
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword">
                        <!-- <textarea class="form-control" id="message-text"></textarea> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="updatePassword">Update Password</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




<?php
include 'includeHTML/footer.php';
?>