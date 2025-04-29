<?php
session_start(); 
include "../../tema/includes/header/header.php";
$map = isset($_GET['map']) && $_GET['map'] === 'on';
?>
<div class="container min-vh-100 my-5">
    <div class="pb-5 border-bottom">
        <?php
        include "../../tema/home/searchbar/searchbar.php";
        include "../../tema/ads/category/adscategory.php";
        ?>
    </div>

    <div class="row">
        <!-- Sol: İlanlar -->
        <div class="<?= $map ? 'col-lg-7' : 'col-12' ?>">
            <?php include "../../tema/ads/card/adscard.php"; ?>
        </div>

        <!-- Sağ: Harita (map açık ise) -->
        <?php if ($map): ?>
            <div class="col-lg-5 mt-4">
                <?php include "../../tema/ads/map/adsmap.php"; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include "../../tema/includes/footer/footer.php"; ?>