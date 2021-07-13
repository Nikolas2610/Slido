<?php
include_once 'header.php';
?>

<div class="container">
    <div class="content">
    <?php 
        if (isset($_SESSION['userId'])) {
            echo "<h1>Hello, <strong>" . $_SESSION['username'] . "</strong>!</h1>"; 
        } else {
            echo "<h1>Content is not ready yet!</h1>";
        }
    ?>
    </div>
</div>

<?php
include_once 'footer.php';
?>