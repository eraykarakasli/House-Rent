<?php
include "../../tema/includes/config.php";

$userId = $_SESSION['user_id'];

// Sayfalama ayarları
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;

// Favoriler
$stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$favorites = json_decode($user['favorites'] ?? '[]', true);

$ads = [];
$totalAds = count($favorites);
$totalPages = ceil($totalAds / $perPage);

if (!empty($favorites)) {
    $favoritesSlice = array_slice($favorites, $offset, $perPage);
    $placeholders = implode(',', array_fill(0, count($favoritesSlice), '?'));
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE id IN ($placeholders)");
    $stmt->execute($favoritesSlice);
    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="col-md-8 col-lg-9">
  <div class="row shadow-sm border rounded-4 p-4 mb-4">
    <h4 class="fw-semibold">Seçilmişlər</h4>
  </div>

  <?php if (empty($ads)): ?>
    <div class="alert alert-warning">Hələlik seçilmiş elanınız yoxdur.</div>
  <?php else: ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      <?php foreach ($ads as $ad): ?>
        <?php
          $images = json_decode($ad['images'], true);
          $firstImage = !empty($images) ? "../../tema/" . ltrim($images[0], '/') : "../../assets/no-image.webp";
        ?>
        <div class="col">
          <a href="../../pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>" class="text-decoration-none text-dark">
            <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="position-relative" style="height: 200px;">
                <img src="<?= htmlspecialchars($firstImage) ?>" class="w-100 h-100" style="object-fit: cover;" alt="İlan Resmi">
                <a href="#" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2"
                   onclick="toggleFavorite(event, <?= $ad['id'] ?>)">
                  <i class="bi <?= in_array((int)$ad['id'], $favorites) ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
                </a>
              </div>
              <div class="p-2">
                <div class="d-flex justify-content-between mb-2">
                  <strong><?= number_format($ad['price'], 0, ',', ' ') ?> AZN</strong>
                  <small class="text-muted"><?= date("d.m.Y", strtotime($ad['created_at'])) ?></small>
                </div>
                <div class="text-secondary mb-2">
                  <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($ad['neighborhood']) ?>
                </div>
                <div class="d-flex justify-content-between text-secondary">
                  <span><i class="bi bi-building me-1"></i><?= $ad['floor'] ?></span>
                  <span><i class="bi bi-door-open me-1"></i><?= $ad['room_count'] ?> otaq</span>
                  <span><i class="bi bi-aspect-ratio me-1"></i><?= $ad['area'] ?> m²</span>
                </div>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  <?php endif; ?>
</div>

<script>
function toggleFavorite(e, adId) {
  e.preventDefault();
  e.stopPropagation();
  const icon = e.currentTarget.querySelector("i");

  fetch('../../tema/includes/add_fav.php?id=' + adId)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        icon.classList.toggle("bi-heart-fill");
        icon.classList.toggle("bi-heart");
        icon.classList.toggle("text-danger");

        if (window.location.href.includes("favorites.php") && data.action === "removed") {
          const card = e.currentTarget.closest(".col");
          if (card) card.remove();

          const remaining = document.querySelectorAll(".col");
          if (remaining.length === 0) {
            document.querySelector(".row")?.insertAdjacentHTML("beforebegin", '<div class="alert alert-warning">Hələlik seçilmiş elanınız yoxdur.</div>');
          }
        }
      } else {
        alert("Hata: " + data.message);
      }
    });
}
</script>
