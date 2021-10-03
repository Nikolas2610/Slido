<?php
include 'includeHTML/header.php';
include 'includeHTML/header3.php';
include 'includes/globalVariables.inc.php';

// Check if the user is login or send him to index.php
if (!isset($_SESSION['userId'])) {
    header("location: " . $url . "index.php");
    exit();
}
?>

<div class="container-lg">
    <div class="row p-2">
        <h4 class="text-center"> <a href="events.php" class="eventName"><i class="bi bi-chevron-left icons-size"></i></a> <?php echo $_SESSION['event_name'] . ' #' . $_SESSION['event_id'] ?></h4>
    </div>
    <form method="POST" action="includes/creator/needPassword.inc.php">
        <div class="row p-2">
            <div class="col">
                <input type="password" class="form-control" id="password" placeholder="Event Password" name="password">
            </div>
        </div>
        <div class="row p-2">
            <div class="col text-center">
                <button type="submit" class="btn button" name="confirmPassword">Confirm</button>
            </div>
        </div>
    </form>
</div>

<?php
include 'includeHTML/footer.php';
?>