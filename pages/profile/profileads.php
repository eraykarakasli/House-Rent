<?php
include "../../tema/includes/session_check.php";
include "../../tema/includes/header/header.php";
?>

<div class="container min-vh-100 my-5">
    <div class="row">

        <?php include "../../tema/profile/sidebar/profilesidebar.php"; ?>

        <?php
        // Hedef sayfa parametresi: ?page=ads OR ?page=new
        $page = isset($_GET['page']) ? $_GET['page'] : 'ads';

        switch ($page) {
            case 'new':
                include "../../tema/profile/content/post-ad.php";
                break;
            case 'ads':
            default:
                include "../../tema/profile/content/profileads.php";
                break;
        }
        ?>

    </div>
</div>

<?php include "../../tema/includes/footer/footer.php"; ?>
