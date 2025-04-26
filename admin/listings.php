<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Onayla
if (isset($_GET['approve'])) {
    $id = (int) $_GET['approve'];
    $stmt = $baglanti->prepare("UPDATE ads SET status = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: listings.php?status=approved");
    exit;
}

// Reddet
if (isset($_GET['reject'])) {
    $id = (int) $_GET['reject'];
    $stmt = $baglanti->prepare("UPDATE ads SET status = 0 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: listings.php?status=rejected");
    exit;
}

// Sil
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $baglanti->prepare("DELETE FROM ads WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: listings.php?status=deleted");
    exit;
}

// Sadece status = 0 (onay bekleyen) ilanları çek
$stmt = $baglanti->query("SELECT * FROM ads WHERE status = 0 ORDER BY created_at DESC");
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container-fluid px-4 my-5">
    <h4 class="mb-4"><i class="bi bi-megaphone me-2"></i> Elanlar</h4>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'approved'): ?>
            <div class="alert alert-success">✅ Elan təsdiqləndi.</div>
        <?php elseif ($_GET['status'] == 'rejected'): ?>
            <div class="alert alert-warning">🚫 Elan rədd edildi.</div>
        <?php elseif ($_GET['status'] == 'deleted'): ?>
            <div class="alert alert-danger">🗑️ Elan silindi.</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach ($ads as $ad): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm rounded-4 h-100">
                    <?php
                    $images = json_decode($ad['images'], true);

                    if (!empty($images)) {
                        if (count($images) == 1) {
                            // Sadece 1 resim varsa
                            $firstImagePath = __DIR__ . '/../tema/' . $images[0];
                            $firstImage = (file_exists($firstImagePath)) ? '/tema/' . $images[0] : '/assets/img/default.jpg';
                    ?>
                            <img src="<?= htmlspecialchars($firstImage) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Elan şəkli">
                        <?php
                        } else {
                            // Birden fazla resim varsa carousel yap (OTOMATİK KAYDIRMA YOK)
                            $carouselId = 'carousel_' . $ad['id'];
                        ?>
                            <div id="<?= $carouselId ?>" class="carousel slide">
                                <div class="carousel-inner" style="height: 200px; object-fit: cover;">
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

                                <!-- Sol/sağ butonlar -->
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
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($ad['title']) ?></h5>
                        <p class="mb-1"><strong>Qiymət:</strong> <?= number_format($ad['price'], 2) ?> ₼</p>
                        <p class="mb-1"><strong>Kateqoriya:</strong> <?= htmlspecialchars($ad['category']) ?></p>
                        <p class="mb-1"><strong>Otaq sayı:</strong> <?= htmlspecialchars($ad['room_count']) ?></p>
                        <p class="mb-1"><strong>Sahə:</strong> <?= htmlspecialchars($ad['area']) ?> m²</p>
                        <p class="mb-1"><strong>Ünvan:</strong> <?= htmlspecialchars($ad['address']) ?></p>
                        <p class="small text-muted">Əlavə tarixi: <?= date('d.m.Y H:i', strtotime($ad['created_at'])) ?></p>

                        <!-- Status Rozeti -->
                        <?php if ($ad['status'] == 1): ?>
                            <span class="badge bg-success">Yayında</span>
                        <?php elseif ($ad['status'] == 0): ?>
                            <span class="badge bg-warning text-dark">Gözləmədə</span>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer bg-white d-flex justify-content-between">
                        <?php if ($ad['status'] == 0): ?>
                            <a href="?approve=<?= $ad['id'] ?>" class="btn btn-success btn-sm">
                                <i class="bi bi-check-circle"></i> Təsdiqlə
                            </a>
                            <a href="?reject=<?= $ad['id'] ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-x-circle"></i> Rədd et
                            </a>
                        <?php endif; ?>
                        <a href="?delete=<?= $ad['id'] ?>" onclick="return confirm('Bu elanı silmək istədiyinizə əminsiniz?')" class="btn btn-danger btn-sm ms-auto">
                            <i class="bi bi-trash"></i> Sil
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($ads)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Hələ heç bir elan əlavə edilməyib.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>