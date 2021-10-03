<div class="container-lg">
    <div class="row p-3 mb-2">
        <h4 class="text-center"> <a href="events.php" class="eventName"><i class="bi bi-chevron-left icons-size"></i></a> <?php echo $_SESSION['event_name'] . ' #' . $_SESSION['event_id'] ?></h4>
    </div>
    <div class="row">
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
            <div class="row">
                <div class="col p-3 border-bottom">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border-bottom">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border-bottom">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border">
                    Poll 1
                </div>
            </div>
            <div class="row">
                <div class="col p-3 border">
                    Poll 1
                </div>
            </div>
        </div>
        <div class="col-7" id="pollResult">
            <div class="mw-100">
                <div class="row p-3 align-items-center border-bottom">
                    <div class="col-9 display-6">Did you like Coffee?</div>
                    <div class="col-3 text-end"><span class="d-inline-block span-inline">3</span> <i class="bi bi-people-fill"></i></div>
                </div>
                <!-- Answers -->
                <!-- Answer 1 -->
                <div class="row ms-5 p-2 align-items-center ">
                    <div class="p-1">
                        Answer 1
                    </div>
                    <div class="p-1">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                        </div>
                    </div>
                </div>
                <!-- Answer 2 -->
                <div class="row ms-5 p-2 align-items-center ">
                    <div class="p-1">
                        Answer 2
                    </div>
                    <div class="p-1">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>