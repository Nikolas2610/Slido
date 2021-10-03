<div class="row border-bottom p-1 msgs" id="">
    <div class="row align-items-center">
        <div class="col text-center">
            <i class="bi bi-person-fill icons-size"></i>
        </div>
        <div class="col-8 text-center">
            <div class="row">
                <div class="col text-start">Sender</div>
            </div>
            <div class="row">
                <div class="col-lg-2 text-start">10 <i class="bi bi-hand-thumbs-up-fill"></i></div>
                <div class="col-lg-10 text-start">Yesterday</div>
            </div>
        </div>
        <div class="col-1 d-none d-sm-block" id="declineQuestion">
            <i class="bi bi-check2 icons-size" title="Mark as answered"></i>
        </div>
        <div class="col-1">
            <i class="bi bi-chevron-double-up icons-size" id="highlightQuestion" data-bs-toggle="tooltip" data-bs-placement="top" title="Highlight"></i>
        </div>
        <div class="col-1">
            <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown"></i>
            <ul class="dropdown-menu" aria-labelledby="dropMenu">
                <li><a class="dropdown-item click" id="editCreatorQuestion" data-bs-toggle="modal" data-bs-target="#editMsg" data-bs-whatever="@mdo">Edit</a></li>
                <li><a class="dropdown-item click" id="archiveQuestion">Archive</a></li>
                <li><a class="dropdown-item click" id="declineQuestion">Delete</a></li>
            </ul>
        </div>
    </div>
    <div class="row align-items-center p-1">
        <div class="col" id="messageLabel' . $result['msgId'] . '">Hello<span></span></div>
    </div>
</div>

<div class="row border-bottom p-1 msgs" id="">
    <div class="row align-items-center">
        <div class="col text-center">
            <i class="bi bi-person-fill icons-size"></i>
        </div>
        <div class="col-8 text-center">
            <div class="row">
                <div class="col text-start">Sender</div>

            </div>
            <div class="row">
                <div class="col-lg-2 text-start">10 <i class="bi bi-hand-thumbs-up-fill"></i></div>
                <div class="col-lg-10 text-start">Yesterday</div>
            </div>
        </div>
        <div class="col-1 d-none d-sm-block" id="declineQuestion">
            <i class="bi bi-check2 icons-size" title="Mark as answered"></i>
        </div>
        <div class="col-1">
            <i class="bi bi-chevron-double-up icons-size" id="highlightQuestion" data-bs-toggle="tooltip" data-bs-placement="top" title="Highlight"></i>
        </div>
        <div class="col-1">
            <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown"></i>
            <ul class="dropdown-menu" aria-labelledby="dropMenu">
                <li><a class="dropdown-item click" id="editCreatorQuestion" data-bs-toggle="modal" data-bs-target="#editMsg" data-bs-whatever="@mdo">Edit</a></li>
                <li><a class="dropdown-item click" id="replayQuestion" data-bs-toggle="modal" data-bs-target="#replyMessage" data-bs-whatever="@mdo">Reply</a></li>
                <li><a class="dropdown-item click" id="archiveQuestion">Archive</a></li>
                <li><a class="dropdown-item click" id="declineQuestion">Delete</a></li>
            </ul>
        </div>
    </div>
    <div class="row align-items-center p-1">
        <div class="col" id="messageLabel' . $result['msgId'] . '">Hello<span></span></div>
    </div>
</div>