<?php

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: /login.php");
    exit;
}

$stmt = $baglanti->prepare("SELECT * FROM ads WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-8 col-lg-9">
    <!-- Sayfa Başlığı ve Buton -->
    <div class="d-flex justify-content-between align-items-center shadow-sm border rounded-4 p-4 mb-4 flex-wrap gap-3">
        <h4 class="fw-semibold mb-0">Elanlarım</h4>
        <a href="profileads.php?page=new" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-circle me-2"></i> Yeni Elan Yarat
        </a>
    </div>
    <!-- alert -->
    <?php if (isset($_GET['deleted'])): ?>
        <?php
        $msgType = 'danger';
        $msgText = 'Bilinməyən xəta baş verdi.';

        if ($_GET['deleted'] === 'success') {
            $msgType = 'success';
            $msgText = 'Elan uğurla silindi.';
        } elseif ($_GET['deleted'] === 'unauthorized') {
            $msgText = 'Bu elanı silmək üçün icazəniz yoxdur.';
        } elseif ($_GET['deleted'] === 'invalid') {
            $msgText = 'Keçərsiz istək göndərildi.';
        }
        ?>
        <div class="alert alert-<?= $msgType ?> alert-dismissible fade show mt-3" role="alert">
            <?= $msgText ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Bağla"></button>
        </div>
    <?php endif; ?>



    <!-- Elan Kartları -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach ($ads as $ad): ?>
            <?php
            $images = json_decode($ad['images'], true);
            $imagePath = (!empty($images) && isset($images[0]))
                ? '/tema/' . ltrim($images[0], '/')
                : '/tema/assets/no-image.webp';
            ?>
            <div class="col">
                <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="<?= htmlspecialchars($imagePath) ?>" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="İlan Foto">

                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="fs-6"><?= number_format($ad['price'], 0, ',', ' ') ?> AZN</strong>
                            <span class="badge <?= $ad['status'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $ad['status'] ? 'Aktiv' : 'Gizli' ?>
                            </span>
                        </div>
                        <div class="mb-2 text-secondary d-flex align-items-center">
                            <i class="bi bi-geo-alt me-1"></i> <span><?= htmlspecialchars($ad['address']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between text-secondary mb-3">
                            <div><i class="bi bi-building me-1"></i> <?= $ad['floor'] ?></div>
                            <div><i class="bi bi-door-open me-1"></i> <?= $ad['room_count'] ?> otaq</div>
                            <div><i class="bi bi-aspect-ratio me-1"></i> <?= $ad['area'] ?>m²</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/pages/profile/profileads.php?page=edit&id=<?= $ad['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i> Düzəlt
                            </a>



                            <a href="/tema/includes/ad_delete.php?id=<?= $ad['id'] ?>"
                                onclick="return confirm('Elanı silmək istədiyinizə əminsiniz?')"
                                class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash me-1"></i> Sil
                            </a>


                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>