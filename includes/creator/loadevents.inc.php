<?php
session_start();
include_once '../database.inc.php';
include_once '../functions.inc.php';
// Declare Variables
$username = $_SESSION['username'];
$userid = $_SESSION['userId'];
$newEventButton = 0;
$activeRow = 0;
$pastRow = 0;
$futureRow = 0;


// Query
$sql = 'SELECT * FROM events WHERE creator=:username ORDER BY endDate;';
$stmt = $pdo->prepare($sql);
$params = array(
    ':username' => $username
);
$stmt->bindParam(':username', $params[':username'], PDO::PARAM_STR);
if (!$stmt->execute()) {
    echo "Problem with query2";
    // header("location: ../profile.php?error=stmtfailed");
    exit();
}
$count = $stmt->rowCount();
if ($count == 0) {
    echo '
    <div class="row p-3 align-items-center ">
        <div class="col-6"></div>
        <div class="col-6 text-end"><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newEvent" data-bs-whatever="@mdo">+ New Event</a></div>
    </div>
    ';
} else {
    $curentTime = date("Y-m-d", time());
    $pastEvents = array();
    $activeEvents = array();
    $furuteEvents = array();

    // Sort to active, future and past events
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($result['startDate'] > $curentTime) {
            array_push($furuteEvents, $result);
            continue;
        }
        if ($result['endDate'] >= $curentTime) {
            array_push($activeEvents, $result);
            continue;
        } else {
            array_push($pastEvents, $result);
            continue;
        }
    }

    foreach ($furuteEvents as $event) {
        array_push($activeEvents, $event);
    }
    foreach ($pastEvents as $event) {
        array_push($activeEvents, $event);
    }
    foreach ($activeEvents as $event) {
        if ($event['eventStatus'] == 1) {
            $key = '<i class="bi bi-key-fill"></i>';
        } else {
            $key = '';
        }
        if ($event['startDate'] > $curentTime) {
            $color = "white";
            $eventTime = "F";
        } else {
            if ($event['endDate'] >= $curentTime) {
                $color = "green";
                $eventTime = "A";
            } else {
                $color = "black";
                $eventTime = "P";
            }
        }
        if ($newEventButton == 0) {
            $button = '<div class="col-6 text-end"><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newEvent" data-bs-whatever="@mdo">+ New Event</a></div>';
        } else {
            $button = '';
        }
        if ($activeRow == 0 && $eventTime == "A") {
            echo '
        <div class="row p-3 align-items-center ">
            <div class="col-6">Active</div>
            ' . $button . '
        </div>
        ';
            $activeRow++;
            $newEventButton++;
        }
        if ($futureRow == 0  && $eventTime == "F") {
            if ($activeRow > 0 && $futureRow == 0 && $pastRow == 0) {
                $separationToActive = 'border-top mt-5';
            } else {
                $separationToActive = '';
            }
            echo '
        <div class="row p-3 align-items-center ' . $separationToActive . '">
            <div class="col-6">Future</div>
            ' . $button . '
        </div>
        ';
            $futureRow++;
            $newEventButton++;
        }
        if ($pastRow == 0 && $eventTime == "P") {
            if ($activeRow > 0 && $futureRow == 0 && $pastRow == 0) {
                $separationToActive = 'border-top mt-5';
            } else {
                $separationToActive = '';
            }
            echo '
        <div class="row p-3 align-items-center ' . $separationToActive . '">
            <div class="col-6">Past</div>
            ' . $button . '
        </div>
        ';
            $pastRow++;
            $newEventButton++;
        }
        echo '
        <div class="row p-2 hoverRow mb-2 rounded-pill event " id="' . $event['publishId'] . '">
            <div class="row align-items-center ">
                <div class="col col-md-1 text-center">
                    <i class="bi bi-calendar-event-fill  ' . $color . '"></i>
                </div>
                <div class="col-9 col-md-10">
                    <div class="row" id="' . $event['publishId'] . '">
                        <a class="eventName">' . $key . ' ' . $event['eventName'] . '  #' . $event['publishId'] . '</a> 
                    </div>
                    <div class="row">
                        ' . changeDateFormatTo_dMY($event['startDate']) . ' - ' . changeDateFormatTo_dMY($event['endDate']) . '
                    </div>
                </div>
                <div class="col-1" id="dropMenu"> 
                    <i class="bi bi-three-dots-vertical icons-size" data-bs-toggle="dropdown" id="eventDropMenu"></i>
                        <ul class="dropdown-menu" aria-labelledby="dropMenu">
                            <li><a class="dropdown-item" href="includes/creator/event.inc.php?room=' . $event['publishId'] . '&eventname= ' . $event['eventName'] . '">Open</a></li>
                            <li><a class="dropdown-item" id="shareButton" data-bs-toggle="modal" data-bs-target="#shareEvent" data-bs-whatever="@mdo">Share Link</a></li>
                            <li><a class="dropdown-item" id="editButton">Edit</a></li>
                            <li><a class="dropdown-item" id="duplicateButton">Duplicate</a></li>
                            <li><a class="dropdown-item" id="deleteButton">Delete</a></li>
                        </ul>
                </div>
            </div>
        </div>
    ';
    }
    exit();
}
