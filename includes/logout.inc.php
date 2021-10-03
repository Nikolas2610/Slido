<?php
// Destroy session variables and send the user back to home page
session_start();
session_unset();
session_destroy();
setcookie('user_id', null, -1, '/');
header("location: ../index.php");
exit();
