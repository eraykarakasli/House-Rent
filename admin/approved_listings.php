<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Sayfa ve Arama Ayarları
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, $page);
$limit = 10;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Silme işlemi
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $baglanti->prepare("DELETE FROM ads WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: approved_listings.php");
    exit;
}

// Toplam ilan sayısını bul
if ($search != '') {
    $searchNumeric = is_numeric($search) ? (int)$search : 0;
    $countStmt = $baglanti->prepare("SELECT COUNT(*) FROM ads WHERE status = 1 AND (id = ? OR title LIKE ? OR category LIKE ?)");
    $countStmt->execute([$searchNumeric, "%$search%", "%$search%"]);
} else {
    $countStmt = $baglanti->query("SELECT COUNT(*) FROM ads WHERE status = 1");
}
$totalAds = $countStmt->fetchColumn();
$totalPages = ceil($totalAds / $limit);

// İlanları çek
if ($search != '') {
    $searchNumeric = is_numeric($search) ? (int)$search : 0;
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE status = 1 AND (id = ? OR title LIKE ? OR category LIKE ?) ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
    $stmt->execute([$searchNumeric, "%$search%", "%$search%"]);
} else {
    $stmt = $baglanti->query("SELECT * FROM ads WHERE status = 1 ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
}
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4 my-5">
    <h4 class="mb-4"><i class="bi bi-list-check me-2"></i> Təsdiqlənmiş Elanlar</h4>

    <!-- Search Bar -->
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="ID, Başlıq və ya Kateqoriyada axtar..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Axtar</button>
        </div>
    </form>

    <!-- İlan Tablosu -->
    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Başlıq</th>
                            <th>Kateqoriya</th>
                            <th>Qiymət (₼)</th>
                            <th>Əlavə Tarixi</th>
                            <th class="text-end">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ads as $ad): ?>
                            <tr>
                                <td><?= $ad['id'] ?></td>
                                <td><?= htmlspecialchars($ad['title']) ?></td>
                                <td><?= htmlspecialchars($ad['category']) ?></td>
                                <td><?= number_format($ad['price'], 2) ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($ad['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="?delete=<?= $ad['id'] ?>" onclick="return confirm('Bu elanı silmək istədiyinizə əminsiniz?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Sil
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($ads)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Heç bir təsdiqlənmiş elan tapılmadı.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include './includes/footer.php'; ?>
