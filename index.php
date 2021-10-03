<?php
// Include the header
include_once 'includeHTML/header.php';

unset($_SESSION['guest_event_id']);
unset($_SESSION['guest_event_name']);
unset($_SESSION['poll_id']);
unset($_SESSION['live_button']);
unset($_SESSION['event_id']);
unset($_SESSION['event_name']);
?>

<div class="container-lg">
    <div class="row">
        <h1 class="font-monospace display-1 text-center my-5" id="title">Slido</h1>
    </div>
    <div class="row p-2 border-bottom pb-5">
        <form method="POST" action="includes/guest/findEvent.inc.php">
            <div class="row justify-content-center align-items-center">
                <!-- <div class="display-6 text-center my-5">Join Event</div> -->
                <div class="form-floating mb-3 text-dark">
                    <input type="text" class="form-control text-dark halfwidth" id="floatingInput" placeholder="#013245" name="joinEventHome">
                    <label for="floatingInput">Event Code</label>
                </div>
            </div>
            <div class="row p-2">
                <div class="col text-center">
                    <button type="submit" class="btn button" name="join">Join Event</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row p-2 mt-5">

        <div class="row p-2">
            <div class="col">
                <h5 class="text-center editprofile">Do you wanna to create your own event?</h5>
            </div>
        </div>
        <div class="row mt-3 p-2">
            <div class="col text-center">
                <a href="login.php" class="indexa">Login in </a> <br> or <br><a href="signUp.php" class="indexa">Sign Up</a>
            </div>
        </div>

    </div>



</div>

<?php
// Include the footer
include_once 'includeHTML/footer.php';
?>