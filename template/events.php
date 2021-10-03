    <!-- Bar active/past/future -->
    <div class="row p-3 align-items-center ">
        <div class="col-6">Active</div>
        <div class="col-6 text-end"><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newEvent" data-bs-whatever="@mdo">+ New Event</a></div>
    </div>

    <div class="row p-2 hoverRow mb-2 rounded-pill">
        <div class="row align-items-center ">
            <div class="col col-md-1 text-center">
                <i class="bi bi-calendar-event-fill icons-size"></i>
            </div>
            <div class="col-9 col-md-10 text-center">
                <div class="row pointer">
                    Psillovits Event
                </div>
                <div class="row pointer">
                    21/5/2020 - 22/5/2020
                </div>
            </div>
            <div class="col-1" id="dropMenu"> 
                <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown"></i>
                <ul class="dropdown-menu" aria-labelledby="dropMenu">
                    <li><a class="dropdown-item" href="event.php?room=' . $result['publishId'] . '">Open</a></li>
                    <li><a class="dropdown-item" href="#">Edit</a></li>
                    <li><a class="dropdown-item" href="#">Duplicate</a></li>
                    <li><a class="dropdown-item" id="deleteButton">Delete</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="row p-2 hoverRow mb-2 rounded-pill">
        <div class="row align-items-center">
            <div class="col col-md-1 text-center">
                <i class="bi bi-calendar-event-fill icons-size"></i>
            </div>
            <div class="col-9 col-md-10 text-center">
                <div class="row ">
                    Psillovits Event
                </div>
                <div class="row">
                    21/5/2020 - 22/5/2020
                </div>
            </div>
            <div class="col-1">
                <i class="bi bi-three-dots-vertical icons-size"></i>
            </div>
        </div>
    </div>