<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Slido</title>
</head>

<body>
        <nav class="navbar navbar-expand-md navbar-dark">
            <a href="index.php" class="navbar-brand">SLIDO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="toggleMobileMenu">
                <ul class="navbar-nav text-center ms-auto">
                    <li>
                        <a href="index.php" class="nav-link links">Home</a>
                    </li>
                    <?php
                    if (isset($_SESSION['userId'])) {
                        echo '<a href="" class="nav-link">Profile Page</a>';
                        echo '<a href="includes/logout.inc.php" class="nav-link">Log out</a>';
                    } else {
                        echo '<a href="login.php" class="nav-link">Sign In</a>';
                        echo '<a href="signUp.php" class="nav-link">Sign Up</a>';
                    }
                    ?>
                </ul>
            </div>
        </nav>