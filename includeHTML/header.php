<?php
// To control user details
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <!-- Boostrap Icons -->
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> -->
    <link rel="stylesheet" href="css/toastr.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css?v=<?php echo rand(); ?>" type="text/css">
    <link rel="shortcut" type="image/png" href="css/imgs/polling.png"/>

    <title>Slido</title>
</head>

<body>
    <!-- Navbar -->
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
                if (isset($_SESSION['event_name'])) {
                    $page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
                    if ($page == 'polls.php' || $page == 'qa.php' || $page == 'eventsettings.php') {
                        echo '<li class="nav-item dropdown">
                        <a class="nav-link">
                        ' . $_SESSION['event_name'] . ' #' . $_SESSION['event_id'] . '
                            </a>
                        </li>';
                    }
                }
                // Show different if user is log in or not
                if (isset($_SESSION['username'])) {
                    echo '
                    <li>
                        <a class="nav-link" aria-current="page" href="events.php" id="events">Events</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ' . $_SESSION['username'] . '
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php">Join Event</a></li>
                        <li><a class="dropdown-item" href="profile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="contact.php">Send us Feedback</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="includes/logout.inc.php">Log Out</a></li>
                    </ul>
                  </li>
                ';
                    echo '<a href="contact.php" class="nav-link">Contact</a>';
                } else {
                    // <a href="profile.php" class="nav-link dropdown-toggle" type="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">' . $_SESSION['username'] . '</a>
                    $url = $_SERVER['REQUEST_URI'];
                    $path = explode('/', $url);
                    echo '<a href="login.php" class="nav-link">Sign In</a>';
                    echo '<a href="signUp.php" class="nav-link">Sign Up</a>';
                    echo '<a href="contact.php" class="nav-link">Contact</a>';
                }
                ?>
            </ul>
        </div>
    </nav>