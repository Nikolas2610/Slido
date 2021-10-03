<?php
include '../functions.inc.php';

$username = $_SESSION['username'];
if (!isset($_SESSION['event_id'])) {
    $event_id = $_POST['id'];
} else {
    $event_id = $_SESSION['event_id'];
}
echo $event_id;


$event = getDetailsEvent($username, $event_id);