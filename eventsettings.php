<?php
// Includes Files
include 'includeHTML/header.php';
include 'includes/globalVariables.inc.php';

// Check if the user is login or send him to index.php
if (!isset($_SESSION['userId'])) {
    header("location: " . $url . "index.php");
    exit();
}
// Password Needed
if (isset($_SESSION['event_status'])) {
    if ($_SESSION['event_status']) {
        if (isset($_SESSION['pwd_match'])) {
            if ($_SESSION['pwd_match'] == 0) {
                header("location: " . $url . "events.php?error=passwordneeded");
            }
        } else {
            header("location: " . $url . "events.php?error=passwordneeded");
        }
    }
} else {
    header("location: " . $url . "needPassword.php");
}


include 'includeHTML/header3.php';
include 'includes/functions.inc.php';

$username = $_SESSION['username'];
$event_id = $_SESSION['event_id'];

// Get event Details
$event = getDetailsEvent($username, $event_id);
$event['startDate'] = changeTimeDashForHTML($event['startDate']);
$event['endDate'] = changeTimeDashForHTML($event['endDate']);

if (!isset($event)) {
    echo "Problem with the query";
    header("location: " . $url . "events.php?error=stmtfailed");
    // Send them back
}

?>
<div class="container-lg">
    <div class="row p-3 rounded-pill border-bottom mb-5 mt-3">
        <div class="col">
            <h3>Event Settings</h3>
        </div>
    </div>

    <form method="POST" action="includes/creator/updateEvent.inc.php">
        <div class="mb-3">
            <input type="text" class="form-control" id="eventName" value="<?php echo $event['eventName']; ?>" name="eventName">
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" id="invitePeople" placeholder="Invite People by Email (comma separate)(Not ready yet)" name="invitePeople" multiple>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <input type="text" class="form-control" id="startDate" value="<?php echo $event['startDate']; ?>" name="startDate">
                </div>
                <div class="col-sm-6 mb-3">
                    <input type="text" class="form-control" id="endDate" value="<?php echo $event['endDate']; ?>" name="endDate">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="reviewQa" name="reviewQa" <?php if ($event['reviewQa'] == 1) {
                                                                                                            echo "checked='checked'";
                                                                                                        }; ?>>
                <label class="form-check-label" for="reviewQa">
                    Review QA
                </label>
            </div>
        </div>
        <div class="mb-3 pt-3 border-top">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="privateEvent" name="privateEvent" <?php if ($event['eventStatus'] == 1) {
                                                                                                                    echo "checked='checked'";
                                                                                                                }; ?>>
                <label class="form-check-label" for="privateEvent">
                    Private Event
                </label>
            </div>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="eventPassword" placeholder="Change Password Event" name="eventPassword" value="<?php if ($event['eventStatus'] == 1) {
                                                                                                                                                echo $_SESSION['pwd'];
                                                                                                                                            } ?>" disabled>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="eventConfirmPassword" placeholder="Confirm Password Event" name="eventConfirmPassword" value="<?php if ($event['eventStatus'] == 1) {
                                                                                                                                                                echo $_SESSION['pwd'];
                                                                                                                                                            } ?>" disabled>
        </div>
</div>
<div class="col text-center">
    <button type="submit" class="btn button" name="saveChanges">Save Changes</button>
</div>


</form>
</div>
<?php
include 'includeHTML/footer.php';
?>