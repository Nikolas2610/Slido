<?php
// Include the header
include 'includeHTML/header.php';
// include 'includeHTML/header2.php';
include 'includes/globalVariables.inc.php';

// // Check if the user is login or send him to index.php
if (!isset($_SESSION['userId']) || !isset($_SESSION['username'])) {
    header("location: " . $url . "index.php");
    exit();
}
// Destroy password session variables
// unset($_SESSION['event_id']);
unset($_SESSION['pwd_match']);
unset($_SESSION['pwd']);
unset($_SESSION['event_id']);
unset($_SESSION['event_name']);
unset($_SESSION['event_status']);
unset($_SESSION['reviewQa']);
?>

<div class="container-lg scrollDiv">
    <div class="row p-2 mt-2 align-items-center justify-content-center rounded-pill border-bottom">
        <div class="col text-center fs-3">Events</div>
    </div>
    <!-- Load event from Ajax Call -->
    <div id="loadEvents"></div>
    <div id="test"></div>


    <!-- Share Link or Invite People Modal -->
    <div class="modal fade bg-gradient" id="shareEvent" tabindex="-1" aria-labelledby="shareEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-dark bg-gradient">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareEventLabel">Share Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="includes/creator/invitePeople.inc.php">
                        <div class="mb-3">
                            <label for="shareLink" class="form-label">Share link:</label>
                            <div class="row align-items-center">
                                <div class="col-11">
                                    <input type="text" class="form-control" id="shareLink" name="shareLink">
                                </div>
                                <div class="col-1">
                                    <i class="bi bi-clipboard" id="copyLink"></i>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col mb-3" id="successCopy"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-success" id="addEmail" type="button">Add new email</button>
                        </div>
                        <!-- Oprions -->
                        <div id="addEmails">
                            <div class="row align-items-center mb-3">
                                <div class="col">
                                    <input type="email" class="form-control option" placeholder="Add email" name="email1">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="inviteByEmail">Invite</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- New Event Modal -->
    <div class="modal fade bg-gradient" id="newEvent" tabindex="-1" aria-labelledby="newEventLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-dark bg-gradient">
                <div class="modal-header">
                    <h5 class="modal-title" id="newEventLabel">New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="includes/createEvent.inc.php">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="eventName" placeholder="Event name" name="eventName">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="invitePeople" placeholder="Invite People by Email (comma separate)" name="invitePeople" multiple>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <input type="text" class="form-control" id="startDate" placeholder="Start Date" name="startDate" autocomplete="off">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <input type="text" class="form-control" id="endDate" placeholder="End Date" name="endDate" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="reviewQa" name="reviewQa">
                                <label class="form-check-label" for="reviewQa">
                                    Review Qa
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 pt-3 border-top">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="privateEvent" name="privateEvent">
                                <label class="form-check-label" for="privateEvent">
                                    Private Event
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="eventPassword" placeholder="Password Event Room" name="eventPassword" disabled>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="eventConfirmPassword" placeholder="Confirm Password Event Room" name="eventConfirmPassword" disabled>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="createEvent">Create Event</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    // Print error messages
    include_once 'includes/errors.inc.php';
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        $message = printErrors($error);
        echo $message;
    }
    ?>

</div>


<?php
// Include the footer
include_once 'includeHTML/footer.php';
?>