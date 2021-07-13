<?php
// Set names and passwords of our database
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "slido_project1";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

$dsn = 'mysql:host=' . $serverName .';dbname='. $dBName;
$pdo = new PDO($dsn, $dBUsername, $dBPassword);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
} 