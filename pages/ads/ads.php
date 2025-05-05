<?php
session_name('user_session');
session_start();
include "../../tema/includes/header/header.php";
$isMobile = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/i', $_SERVER['HTTP_USER_AGENT']);
$map = isset($_GET['map']) && $_GET['map'] === 'on';
?>

<div class="container-fluid p-0">
  <?php include "../../tema/includes/header/header.php"; ?>
</div>

<div class="container<?= $map && $isMobile ? '-fluid' : '' ?> <?= $map && $isMobile ? 'p-0' : 'min-vh-100 my-5' ?>">
  <div class="pb-2">
    <?php
    include "../../tema/home/searchbar/searchbar.php";
    include "../../tema/ads/category/adscategory.php";
    ?>
  </div>

  <div class="row m-0">
    <div class="<?= $map ? 'col-lg-7' : 'col-12' ?> <?= $map && $isMobile ? 'd-none' : '' ?>">
      <?php include "../../tema/ads/card/adscard.php"; ?>
    </div>

    <?php if ($map): ?>
      <div class="col-lg-5 <?= $isMobile ? 'p-0' : 'mt-2' ?>">
        <div class="<?= $isMobile ? 'map-fullscreen-mobile' : '' ?>">
          <?php include "../../tema/ads/map/adsmap.php"; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include "../../tema/includes/footer/footer.php"; ?>

<script>
 if (window.innerWidth <= 991 && window.location.href.includes("map=on")) {
  document.body.classList.add("map-open");
  document.documentElement.classList.add("map-open"); // <html> etiketine de ekle
}

</script>

<style>
 @media (max-width: 991.98px) {
  .map-fullscreen-mobile {
    position: fixed;
    top: 190px; /* sadece searchbar + kategori yüksekliği kadar boşluk bırakıyoruz */
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999;
    background-color: #fff;
    display: flex;
    flex-direction: column;
  }

  .map-fullscreen-mobile #map {
    flex: 1;
    width: 100%;
    border-radius: 0 !important;
  }

  body.map-open,
  html.map-open {
    overflow: hidden;
    height: 100%;
    touch-action: none;
  }
}

</style>