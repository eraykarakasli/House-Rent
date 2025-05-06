<?php
session_name('user_session');
session_start();
include "./tema/includes/header/header.php";
?>

<div class="container min-vh-100 mt-5">
    <?php include "./tema/home/searchbar/searchbar.php"; ?>
    <?php include "./tema/home/homesliders/homeslider3.php"; ?>
</div>

<?php include "./tema/includes/footer/footer.php"; ?>