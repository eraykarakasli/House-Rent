<?php
include "../../tema/includes/config.php";
$userFavorites = [];

if (isset($_SESSION['user_id'])) {
    $stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && !empty($user['favorites'])) {
        $userFavorites = json_decode($user['favorites'], true);
    }
}

$map = isset($_GET['map']) && $_GET['map'] === 'on';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 30;
$offset = ($page - 1) * $perPage;

// Filtreler
$where = "WHERE status = 1";
$params = [];

if (!empty($_GET['category'])) {
    $where .= " AND category = ?";
    $params[] = $_GET['category'];
}

if (!empty($_GET['room_count'])) {
    if ($_GET['room_count'] === '5+') {
        $where .= " AND room_count >= 5";
    } else {
        $where .= " AND room_count = ?";
        $params[] = $_GET['room_count'];
    }
}

if (!empty($_GET['min_price'])) {
    $where .= " AND price >= ?";
    $params[] = $_GET['min_price'];
}

if (!empty($_GET['max_price'])) {
    $where .= " AND price <= ?";
    $params[] = $_GET['max_price'];
}

if (!empty($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $where .= " AND (
        CAST(id AS CHAR) LIKE ? OR
        title LIKE ? OR 
        address LIKE ? OR 
        city LIKE ? OR 
        district LIKE ? OR 
        neighborhood LIKE ? OR 
        description LIKE ? OR
        category LIKE ?
    )";
    $params = array_merge($params, array_fill(0, 8, $searchTerm));
}


if (!empty($_GET['operation'])) {
    $where .= " AND operation_type = ?";
    $params[] = $_GET['operation'];
}

if (!empty($_GET['building_type']) && $_GET['building_type'] !== 'her_sey') {
    $where .= " AND building_condition = ?";
    $params[] = $_GET['building_type'];
}

// Sıralama
$sort = $_GET['sort'] ?? null;
$orderClause = "ORDER BY created_at DESC";
if ($sort === 'ucuzdan-bahaya') {
    $orderClause = "ORDER BY price ASC";
} elseif ($sort === 'bahadan-ucuza') {
    $orderClause = "ORDER BY price DESC";
}

// Toplam ilan sayısı
$countQuery = $baglanti->prepare("SELECT COUNT(*) FROM ads $where");
$countQuery->execute($params);
$totalAds = $countQuery->fetchColumn();
$totalPages = ceil($totalAds / $perPage);

// İlanları çek
$stmt = $baglanti->prepare("SELECT * FROM ads $where $orderClause LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-2">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 <?= $map ? 'row-cols-lg-3' : 'row-cols-lg-5' ?> g-4">
        <?php foreach ($ads as $ad): ?>
            <?php
            $imagesArray = json_decode($ad['images'], true);
            $firstImage = !empty($imagesArray) ? "../../tema/" . ltrim($imagesArray[0], '/') : "../../assets/no-image.webp";
            ?>
            <div class="col">
                <a href="../../pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>" class="text-decoration-none text-dark">
                    <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">
                        <div class="position-relative" style="height: 200px;">
                            <img src="<?= htmlspecialchars($firstImage) ?>" class="d-block w-100" alt="İlan Fotoğrafı" style="height: 200px; object-fit: cover;">
                            <a href="#" onclick="toggleFavorite(event, <?= $ad['id'] ?>)" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2 p-1">
                                <i class="bi <?= in_array((int)$ad['id'], $userFavorites) ? 'bi-heart-fill text-danger' : 'bi-heart' ?> p-1"></i>
                            </a>

                            <div class="position-absolute top-0 start-0 m-2">
                                <?php if (!empty($ad['certificate'])): ?>
                                    <span class="btn btn-success btn-sm rounded-circle p-1" title="Çıxarış var">
                                        <i class="bi bi-clipboard-check-fill p-1"></i>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($ad['mortgage'])): ?>
                                    <span class="btn btn-warning btn-sm rounded-circle p-1" title="İpoteka var">
                                        <i class="bi bi-percent p-1"></i>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($ad['renovated'])): ?>
                                    <span class="btn btn-danger btn-sm rounded-circle p-1" title="Təmirli">
                                        <i class="bi bi-hammer p-1"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

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

    <?php if ($totalPages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<script>
    function toggleFavorite(e, adId) {
        e.preventDefault();
        e.stopPropagation();

        const clickedIcon = e.currentTarget.querySelector("i");

        fetch('../../tema/includes/add_fav.php?id=' + adId, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tüm ikonları güncelle
                    const allIcons = document.querySelectorAll(`a[onclick*="toggleFavorite"][onclick*="${adId}"] i`);
                    allIcons.forEach(icon => {
                        icon.classList.remove("bi-heart", "bi-heart-fill", "text-danger");
                        if (data.action === "added") {
                            icon.classList.add("bi-heart-fill", "text-danger");
                        } else {
                            icon.classList.add("bi-heart");
                        }
                    });

                    // Eğer bu işlem favorites.php gibi bir sayfadaysa ve kaldırma yapıldıysa kartı DOM'dan da silelim
                    if (data.action === "removed") {
                        const card = e.closest(".col");
                        if (card) {
                            card.remove();

                            // Eğer hiç favori kalmadıysa uyarı mesajı göster
                            if (document.querySelectorAll('.col').length === 0) {
                                const container = document.querySelector('.col-md-8 .row.g-4.mt-1');
                                if (container) container.innerHTML = `<div class="alert alert-warning">Hələlik seçilmiş elanınız yoxdur.</div>`;
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