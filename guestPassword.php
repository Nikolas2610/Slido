<?php
include 'includeHTML/header.php';
include 'includes/globalVariables.inc.php';
// Check if comes with invite
if (!isset($_SESSION['guest_event_id'])) {
    header("location: " . $url . "index.php");
}

?>

<div class="container-lg">
    <div class="row p-2 mt-2 align-items-center justify-content-center rounded-pill border-bottom">
        <h4 class="text-center"><strong><?php echo $_SESSION['guest_event_name'] . ' #' . $_SESSION['guest_event_id'] ?></strong></h4>
    </div>
    <form method="POST" action="includes/guest/guestPassword.inc.php">
        <div class="row p-3 mt-4">
            <div class="col">
                <input type="password" class="form-control" id="password" placeholder="Event Password" name="password">
            </div>
        </div>
        <div class="row p-3 mt-4">
            <div class="col text-center">
                <button type="submit" class="btn button" name="confirmPassword">Confirm</button>
            </div>
        </div>
    </form>
</div>

<?php
include 'includeHTML/footer.php';
?>