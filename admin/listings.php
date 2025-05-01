<?php
ob_start();
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

if (isset($_GET['approve'])) {
  $id = (int) $_GET['approve'];
  $stmt = $baglanti->prepare("UPDATE ads SET status = 1 WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: listings.php?status=approved");
  exit;
}

if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  $stmt = $baglanti->prepare("DELETE FROM ads WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: listings.php?status=deleted");
  exit;
}

$total = $baglanti->query("SELECT COUNT(*) FROM ads WHERE status = 0")->fetchColumn();
$totalPages = ceil($total / $limit);

$stmt = $baglanti->prepare("SELECT * FROM ads WHERE status = 0 ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
$stmt->execute();
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex-grow-1 position-relative" id="main-content">
  <div class="container-fluid px-4 my-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0"><i class="bi bi-megaphone me-2"></i> Elanlar</h4>
      </div>
    </div>

    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status'] == 'approved'): ?>
        <div class="alert alert-success">✅ Elan təsdiqləndi.</div>
      <?php elseif ($_GET['status'] == 'deleted'): ?>
        <div class="alert alert-danger">🗑️ Elan silindi.</div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="row g-4">
      <?php foreach ($ads as $ad): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
            <?php
            $images = json_decode($ad['images'], true);
            if (!empty($images)) {
              if (count($images) == 1) {
                $firstImagePath = __DIR__ . '/../tema/' . $images[0];
                $firstImage = (file_exists($firstImagePath)) ? '/tema/' . $images[0] : '/assets/img/default.jpg';
                echo '<div style="height: 200px; background: url(' . htmlspecialchars($firstImage) . ') center center / cover no-repeat;"></div>';
              } else {
                $carouselId = 'carousel_' . $ad['id'];
            ?>
                <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
                  <div class="carousel-inner" style="height: 200px;">
                    <?php foreach ($images as $index => $image): ?>
                      <?php
                      $imagePath = __DIR__ . '/../tema/' . $image;
                      $imageSrc = (file_exists($imagePath)) ? '/tema/' . $image : '/assets/img/default.jpg';
                      ?>
                      <div class="carousel-item <?= ($index === 0) ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($imageSrc) ?>" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="Elan şəkli">
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </button>
                </div>
            <?php
              }
            }
            ?>

            <div class="card-body py-3 px-4">
              <h6 class="fw-bold text-truncate" title="<?= htmlspecialchars($ad['title']) ?>">
                <?= htmlspecialchars($ad['title']) ?>
              </h6>
              <p class="mb-1 small"><strong>Qiymət:</strong> <?= number_format($ad['price'], 2) ?> ₼</p>
              <p class="mb-1 small"><strong>Kateqoriya:</strong> <?= htmlspecialchars($ad['category']) ?></p>
              <p class="mb-1 small"><strong>Otaq:</strong> <?= htmlspecialchars($ad['room_count']) ?> · <strong>Sahə:</strong> <?= htmlspecialchars($ad['area']) ?> m²</p>
              <p class="mb-1 small"><strong>Ünvan:</strong> <?= htmlspecialchars($ad['address']) ?></p>
              <p class="small text-muted mb-0">Əlavə tarixi: <?= date('d.m.Y H:i', strtotime($ad['created_at'])) ?></p>
              <span class="badge mt-2 <?= $ad['status'] == 1 ? 'bg-success' : 'bg-warning text-dark' ?>">
                <?= $ad['status'] == 1 ? 'Yayında' : 'Gözləmədə' ?>
              </span>
            </div>
            <div class="card-footer bg-white border-top-0 px-4 pb-3 d-flex justify-content-between">
              <?php if ($ad['status'] == 0): ?>
                <a href="?approve=<?= $ad['id'] ?>" class="btn btn-sm btn-outline-success rounded-pill">
                  <i class="bi bi-check-circle"></i> Təsdiqlə
                </a>
              <?php endif; ?>
              <a href="?delete=<?= $ad['id'] ?>" onclick="return confirm('Bu elanı silmək istədiyinizə əminsiniz?')" class="btn btn-sm btn-outline-danger rounded-pill ms-auto">
                <i class="bi bi-trash"></i> Sil
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (empty($ads)): ?>
        <div class="col-12">
          <div class="alert alert-info text-center">Hələ heç bir elan əlavə edilməyib.</div>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>

<?php include './includes/footer.php'; ?>