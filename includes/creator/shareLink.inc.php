<?php
include '../globalVariables.inc.php';
$eventid = $_POST['id'];
// $hashedEvent = password_hash($eventid, PASSWORD_DEFAULT);
// $hashedEvent = password_hash($eventid, PASSWORD_DEFAULT);
// $test = password_verify($eventid , $hashedEvent);
// $eventid = hex2bin($eventid);
$hashedEvent = base64_encode($eventid);
// $test = base64_decode($hashedEvent, true);
$shareurl = $url . 'joinevent.php?link=' . $hashedEvent;
// $token = bin2hex(openssl_random_pseudo_bytes(16));
// $token2 = hex2bin($token);
// echo $token;
// echo $token2;
echo $shareurl;
