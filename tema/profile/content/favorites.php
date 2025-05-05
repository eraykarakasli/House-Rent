<?php
include "../../tema/includes/config.php";

$userId = $_SESSION['user_id'];

// Kullanıcının favorilerini al
$stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Favoriler verisini düzgün formatta al
$favorites = json_decode($user['favorites'] ?? '[]', true);

// Parametreyi oluşturma
$ads = [];
if (!empty($favorites)) {
    // Favoriler boş değilse, sorgu yapalım
    $placeholders = str_repeat('?,', count($favorites) - 1) . '?';

    // Favori ilanları sorgula
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE id IN ($placeholders)");

    // Execute query with all favorite IDs
    $stmt->execute($favorites);
    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<div class="col-md-8 col-lg-9">
    <!-- Sağ Panel: Seçilmişler -->
    <div class="row shadow-sm border rounded-4 p-4 mb-4">
        <h4 class="fw-semibold">Seçilmişlər</h4>
    </div>

    <!-- Eğer favoriler boşsa uyarı mesajı göster -->
    <?php if (empty($ads)): ?>
        <div class="alert alert-warning">
            Hələlik seçilmiş elanınız yoxdur.
        </div>
    <?php else: ?>
        <!-- Favori ilanların listesi -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 mt-1">
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
                                <a href="#" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2" onclick="toggleFavorite(event, <?= $ad['id'] ?>)">
                                    <i class="bi <?= in_array((int)$ad['id'], $favorites) ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
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
    <?php endif; ?>
</div>

<script>

function toggleFavorite(e, adId) {
    e.preventDefault();
    e.stopPropagation();

    const icon = e.currentTarget.querySelector("i");

    fetch('../../tema/includes/add_fav.php?id=' + adId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // İkonu güncelle
                const allIcons = document.querySelectorAll(`a[onclick*="toggleFavorite"][onclick*="${adId}"] i`);
                allIcons.forEach(ic => {
                    ic.classList.remove("bi-heart", "bi-heart-fill", "text-danger");
                    if (data.action === "added") {
                        ic.classList.add("bi-heart-fill", "text-danger");
                    } else {
                        ic.classList.add("bi-heart");
                    }
                });

                // Eğer bulunduğumuz sayfa favoriler sayfasıysa kartı kaldır
                if (window.location.href.includes("favorites.php") && data.action === "removed") {
                    const card = e.currentTarget.closest(".col");
                    if (card) card.remove();

                    // Eğer hiç kart kalmadıysa uyarı mesajı göster
                    const remainingCards = document.querySelectorAll(".col");
                    if (remainingCards.length === 0) {
                        const container = document.querySelector(".row.row-cols-1");
                        if (container) {
                            container.insertAdjacentHTML("beforebegin", `
                                <div class="alert alert-warning">
                                    Hələlik seçilmiş elanınız yoxdur.
                                </div>
                            `);
                        }
                    }
                }

            } else {
                alert("Favori işlemi başarısız: " + data.message);
            }
        })
        .catch(err => console.error("Hata:", err));
}

</script>
