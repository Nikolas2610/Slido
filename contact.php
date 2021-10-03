<?php
// Include the header
include_once 'includeHTML/header.php';
?>

<div class="container-lg">
    <div class="row p-3 rounded-pill border-bottom mb-5 mt-3">
        <div class="col">
            <h3>Contact Page</h3>
        </div>
    </div>
    <form method="POST" action="includes/admin/contact.inc.php">
        <div class="row">
            <div class="form-floating text-dark mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="firstName" value="<?php
                if (isset($_COOKIE['contact_firstName'])) {
                    echo $_COOKIE['contact_firstName'];
                }
                ?>">
                <label for="floatingInput">First name</label>
            </div>
            <div class="form-floating text-dark mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="lastName" value="<?php
                if (isset($_COOKIE['contact_lastName'])) {
                    echo $_COOKIE['contact_lastName'];
                }
                ?>">
                <label for="floatingInput">Last name (optional)</label>
            </div>
            <div class="form-floating text-dark mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php
                if (isset($_COOKIE['contact_email'])) {
                    echo $_COOKIE['contact_email'];
                }
                ?>">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating text-dark mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="comments" value="<?php
                if (isset($_COOKIE['contact_comments'])) {
                    echo $_COOKIE['contact_comments'];
                }
                ?>"></textarea>
                <label for="floatingTextarea2">Your comments</label>
            </div>
            <div class="col text-center mb-3">
                <button type="submit" class="btn button" name="sendMsg">Send Message</button>
            </div>
            <!-- Errors or Success Msgs -->
            <div class="row">
                <div class="col text-center">
                    <div class="errors alert alert-danger noneDisplay">Error Message</div>
                    <div class="success alert alert-success noneDisplay">Success Message</div>
                </div>
            </div>

        </div>
    </form>

</div>


<?php
// Include the header
include_once 'includeHTML/footer.php';
?>