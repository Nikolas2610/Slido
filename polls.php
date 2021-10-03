<?php
// include files
include 'includes/globalVariables.inc.php';
include 'includeHTML/header.php';

// Security Access
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
                header("location: " . $url . "events.php?error=passwordneeded1");
            }
        } else {
            header("location: " . $url . "events.php?error=passwordneeded2");
        }
    }
} else {
    header("location: " . $url . "events.php?error=passwordneeded3");
}

// Include Headers
include 'includeHTML/header3.php';
include 'includeHTML/livePollHeader.php';

?>


<div class="container-lg">
    <!-- <div class="row p-3">
        <h4 class="text-center"> <a href="events.php" class="eventName"><i class="bi bi-chevron-left icons-size"></i></a> <?php echo $_SESSION['event_name'] . ' #' . $_SESSION['event_id'] ?></h4>
    </div> -->
    <!-- <div class="row">
        <div class="col-5 bg-light text-dark" id="allPolls">
            <div class="row border-bottom border-dark">
                <div class="col p-3">
                    Poll 1
                </div>
                <div class="col-2 p-3">
                    <div class="col text-end">
                        55 <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="col-1 p-3">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>
            <div class="row border-bottom border-dark pollClick">
                <div class="col p-3">
                    Poll 1
                </div>
                <div class="col-2 p-3">
                    <div class="col text-end">
                        5 <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="col-1 p-3">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>
        </div>
        <div class="col-7" id="pollResult">

        </div>
    </div> -->



    <!-- <div class="row border-bottom p-2">
        <div class="col-7">List</div>
        <div class="col-5 text-end"><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newPoll" data-bs-whatever="@mdo">Create Poll</a></div>
    </div> -->

    <div id="loadPolls"></div>

</div>

<!-- Create Poll Modal -->
<div class="modal fade text-dark bg-gradient" id="newPoll" tabindex="-1" aria-labelledby="createPollLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-gradient">
            <div class="modal-header">
                <h5 class="modal-title" id="createPollLabel">Create Poll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- action="includes/creator/createPoll.inc.php" -->
                <form method="POST" id="createPoll">
                    <select class="form-select mb-3" aria-label="Default select example" name="pollKind" id="pollKind">
                        <option value="1">Multiple Choice</option>
                        <option value="2" disabled>Quiz</option>
                        <option value="3" disabled>Ranking</option>
                        <option value="4">Rating</option>
                    </select>
                    <div id="printPollForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="question" placeholder="What would you like to ask?" name="question">
                        </div>
                        <div class="form-check mb-3">
                            <button class="btn btn-success" id="addAnswer" type="button">Add answer</button>
                        </div>
                        <!-- Oprions -->
                        <div id="pollAnswers">
                            <div class="form-check mb-3">
                                <div class="row align-items-center">
                                    <div class="col-1">
                                        <input class="form-check-input markAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer1" disabled>
                                    </div>
                                    <div class="col-11">
                                        <input type="text" class="form-control option" placeholder="Add option" name="option1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <div class="row align-items-center">
                                    <div class="col-1">
                                        <input class="form-check-input markAnswer" type="checkbox" id="flexSwitchCheckDefault" name="correctAnswer2" disabled>
                                    </div>
                                    <div class="col-11">
                                        <input type="text" class="form-control option" placeholder="Add option" name="option2">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="markAnswers" name="markAnswers">
                                <label class="form-check-label" for="markAnswers">
                                    Mark Correct Answers
                                </label>
                            </div>
                        </div>
                    </div>
            </div>
            <?php
            //    include 'template/rating.php' 
            ?>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" name="savePoll" id="savePoll">Save</button>
                <button type="submit" class="btn btn-primary" name="launchPoll" id="launchPoll">Launch</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Poll Modal -->
<div class="modal fade text-dark bg-gradient" id="editPoll" tabindex="-1" aria-labelledby="editPollLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-gradient">
            <div class="modal-header">
                <h5 class="modal-title" id="editPollLabel">Edit Poll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- action="includes/creator/saveEditPoll.inc.php" -->
                <form method="POST" id="editPollForm">

                    <div id="editPollModal"></div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="saveEditPoll">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
include 'includeHTML/footer.php';
?>