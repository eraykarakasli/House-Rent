<?php
session_name('user_session');
session_start(); 
include "../../tema/includes/session_check.php";
include "../../tema/includes/header/header.php";
?>
<div class="container min-vh-100 my-5">
    <div class="row">
        <?php
        include "../../tema/profile/sidebar/profilesidebar.php";
        ?>
        
        <?php
        include "../../tema/profile/content/favorites.php";
        ?>
        
    </div>
</div>
<?php include "../../tema/includes/footer/footer.php"; ?>