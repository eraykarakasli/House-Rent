<?php

include "../../tema/includes/config.php"; // Veritabanı bağlantısı

$userFavorites = [];

if (isset($_SESSION['user_id'])) {
    // Giriş yaptıysa, kullanıcının favorilerini alalım
    $stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['favorites'])) {
        $userFavorites = json_decode($user['favorites'], true); // JSON'dan array'e çeviriyoruz
    }
}

$map = isset($_GET['map']) && $_GET['map'] === 'on';
$category = $_GET['category'] ?? null;
$sort = $_GET['sort'] ?? null;

// Sıralama türüne göre SQL parçası belirleniyor
$orderClause = "ORDER BY created_at DESC"; // Varsayılan sıralama
if ($sort === 'ucuzdan-bahaya') {
    $orderClause = "ORDER BY price ASC";
} elseif ($sort === 'bahadan-ucuza') {
    $orderClause = "ORDER BY price DESC";
}

// İlanları sorgula
if ($category) {
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE status = 1 AND category = ? $orderClause");
    $stmt->execute([$category]);
} else {
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE status = 1 $orderClause");
    $stmt->execute();
}

$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 <?= $map ? 'row-cols-lg-3' : 'row-cols-lg-5' ?> g-4">
        <?php foreach ($ads as $ad): ?>
            <?php
            // Resimleri JSON'dan alıyoruz
            $imagesArray = json_decode($ad['images'], true);
            $firstImage = !empty($imagesArray) ? "../../tema/" . ltrim($imagesArray[0], '/') : "../../assets/no-image.webp";
            ?>
            <div class="col">
                <a href="../../pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>" class="text-decoration-none text-dark">
                    <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">

                        <!-- İlan Resmi -->
                        <div class="position-relative" style="height: 200px;">
                            <img src="<?= htmlspecialchars($firstImage) ?>" class="d-block w-100" alt="İlan Fotoğrafı" style="height: 200px; object-fit: cover;">
                            <!-- Favori ekle/çıkar butonu -->
                            <a href="../../tema/includes/add_fav.php?id=<?= $ad['id'] ?>" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2">
                                <i class="bi <?= in_array((int)$ad['id'], $userFavorites) ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
                            </a>
                        </div>

                        <!-- İlan Bilgileri -->
                        <div class="p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong class="fs-6"><?= htmlspecialchars(number_format($ad['price'], 0, ',', ' ')) ?> AZN</strong>
                                <small class="text-muted" style="font-size: 12px;"><?= date("d.m.Y", strtotime($ad['created_at'])) ?></small>
                            </div>

                            <div class="mb-2 text-secondary d-flex align-items-center py-2">
                                <i class="bi bi-geo-alt me-1"></i>
                                <span><?= htmlspecialchars($ad['address']) ?></span>
                            </div>

                            <div class="d-flex justify-content-between text-secondary mt-2">
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-building me-1"></i>
                                    <span><?= htmlspecialchars($ad['floor']) ?></span>
                                </div>
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-door-open me-1"></i>
                                    <span><?= htmlspecialchars($ad['room_count']) ?> otaq</span>
                                </div>
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-aspect-ratio me-1"></i>
                                    <span><?= htmlspecialchars($ad['area']) ?>m²</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

