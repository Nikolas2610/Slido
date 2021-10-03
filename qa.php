<?php
include 'includeHTML/header.php';
include 'includes/globalVariables.inc.php';
// Security Check
// // Check if the user is login or send him to index.php
if (!isset($_SESSION['userId'])) {
    header("location: " . $url . "index.php");
    exit();
}
// Password Needed
if (isset($_SESSION['event_status'])) {
    if ($_SESSION['event_status']) {
        if (isset($_SESSION['pwd_match'])) {
            if ($_SESSION['pwd_match'] == 0) {
                header("location: " . $url . "events.php?error=passwordneeded1");
            }
        } else {
            header("location: " . $url . "events.php?error=passwordneeded2");
        }
    }
} else {
    header("location: " . $url . "events.php?error=passwordneeded3");
}

include 'includeHTML/header3.php';
include 'includeHTML/liveQaHeader.php';

?>
<!-- Creator Poll List -->



<!-- <div class="container-lg">
    <div class="row p-2">
        <h4 class="text-center"> <a href="events.php" class="eventName"><i class="bi bi-chevron-left icons-size"></i></a> <?php echo $_SESSION['event_name'] . ' #' . $_SESSION['event_id'] ?></h4>
    </div>
</div> -->
<div class="container-lg">

    <div id="loadQA"></div>

</div>

<!-- Modal Reply Message -->
<div class="modal fade text-dark bg-gradient" id="replyMessage" tabindex="-1" aria-labelledby="replyMsgLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="replyMsgLabel">Replies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Ajax Call -->
                <div id="msgsForReply">
                </div>
                <form method="POST" action="includes/creator/replyMsg.inc.php">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating p-2">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Type your reply" name="replyContent">
                                <label for="floatingInput">Type your reply</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-primary" name="sendReply">Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Message -->
<div class="modal fade text-dark bg-gradient" id="editMsg" tabindex="-1" aria-labelledby="editMsgLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-gradient">
            <div class="modal-header">
                <h5 class="modal-title" id="editMsgLabel">Edit Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="includes/creator/editMsg.inc.php">
                    <div class="mb-3">
                        <!-- <input type="text" class="form-control" id="editMsgModal"> -->
                        <textarea class="form-control" rows="4" id="editMsgModal" name="editMsgModal"></textarea>
                    </div>
                    <div><input class=".d-none" type="text" id="msgId" name="msgId"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-primary" name="editMsg">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
include 'includeHTML/footer.php';
?>