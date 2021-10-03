<?php
// Set names and passwords of our database
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "slido_project1";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);
$db=$conn;
$db->query('set character_set_client=utf8');
$db->query('set character_set_connection=utf8'); 
$db->query('set character_set_results=utf8');
$db->query('set character_set_server=utf8');


$dsn = 'mysql:host=' . $serverName .';dbname='. $dBName;
$pdo = new PDO($dsn, $dBUsername, $dBPassword, array(PDO::ATTR_PERSISTENT => false));
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
} 