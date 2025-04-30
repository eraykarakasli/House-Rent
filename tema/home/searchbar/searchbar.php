<form method="GET" action="/pages/ads/ads.php">
  <div class="container">
    <div class="bg-white shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-3">
      <!-- Sadece Arama -->
      <input type="text" name="search" class="form-control border-0 flex-grow-1"
             placeholder="Şəhər, Metro, Kompleks, Ünvan ..." value="<?= $_GET['search'] ?? '' ?>" />

      <!-- Sadece Filtre Butonu -->
      <a href="#" data-bs-toggle="modal" data-bs-target="#filterModal" class="btn fw-bold text-dark">
        Filterlər
      </a>

      <!-- Ara Butonu -->
      <button type="submit" class="btn btn-info text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>
</form>

<?php include "mobilefilter.php"; ?>
