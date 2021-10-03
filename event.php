<?php
include 'includeHTML/header.php';
include 'includeHTML/header4.php';
include 'includes/globalVariables.inc.php';
include 'includes/functions.inc.php';

if (!isset($_GET['event'])) {
    // Destroy Session Variables
    unset($_SESSION['guest_event_id']);
    unset($_SESSION['guest_event_name']);
    // Go back to index.php
    header("location: " . $url . "index.php?error=noevent");
}
if (!isset($_SESSION['guest_event_id'])) {
    header("location: " . $url . "index.php?error=privateroom");
}



if (!isset($_SESSION['username'])) {
    if (!isset($_SESSION['guest_username'])) {
        $_SESSION['guest_username'] = 'Anonymous';
    }
    $_SESSION['register'] = 0;
} else {
    $_SESSION['register'] = 1;
}
?>
<div class="container-lg">
    <div class="row p-2 mt-2 align-items-center justify-content-center rounded-pill border-bottom">
        <h4 class="text-center"><strong><?php echo $_SESSION['guest_event_name'] . ' #' . $_SESSION['guest_event_id'] ?></strong></h4>
    </div>

    <div class="row p-3 align-items-center">
        <div class="col-8 justify-content-center align-items-center">
            <h5 class=""> Welcome, <?php if (isset($_SESSION['username'])) {
                                        echo '<span class="fst-italic">' . $_SESSION['username'] . '!</span>';
                                    } else {
                                        echo '<span class="fst-italic">' . $_SESSION['guest_username'] . '!</span>';
                                    } ?></h5>
        </div>
        <?php
        if (!isset($_SESSION['username'])) {
            echo '
            <div class="col-4 justify-content-center text-end align-items-center">
                <button class="btn btn-success rounded-pill" name="changeNickname" data-bs-toggle="modal" data-bs-target="#changeNickname" data-bs-whatever="@mdo">Change Nickname</button>
            </div>
            ';
        }
        ?>
    </div>
    <!-- <img src="../Form/css/imgs/live-streaming.svg" alt=""> -->



    <!-- Ajax Call -->
    <div id="msgSend"></div>
    <!-- <div id="loadQA"></div> -->
    <div id="loadLivePoll"></div>


    <!-- Modal Edit Message -->
    <div class="modal fade text-dark bg-gradient" id="editMsg" tabindex="-1" aria-labelledby="editMsgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-gradient">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMsgLabel">Edit Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="includes/guest/editMsg.inc.php">
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

    <!-- Modal Reply Message -->
    <div class="modal fade text-dark bg-gradient" id="replyMessage" tabindex="-1" aria-labelledby="replyMsgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-light text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyMsgLabel">Replies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Ajax Call -->
                    <div id="msgsGuests">
                    </div>
                    <form method="POST" action="includes/creator/replyMsg.inc.php">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating p-2">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Type your reply" name="replyContent" disabled>
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

    <!-- Modal Change Nickname -->
    <div class="modal fade text-dark bg-gradient" id="changeNickname" tabindex="-1" aria-labelledby="changeNicknameLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-light text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeNicknameLabel">Change Nickname</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Ajax Call -->
                    <div id="msgsForReply">
                    </div>
                    <form method="POST" action="includes/guest/changeNickname.inc.php">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating p-2">
                                    <input type="text" class="form-control" id="nickname" placeholder="Type your reply" name="nickname">
                                    <label for="nickname">New nickname</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                            <button type="submit" class="btn btn-primary" name="changeNicknameBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
include 'includeHTML/footer.php';
?>