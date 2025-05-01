<?php
ob_start();
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Arama ve sayfalama
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

// Silme işlemi
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $baglanti->prepare("DELETE FROM complaints WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: complaints.php");
    exit;
}

// Toplam kayıt sayısı
if ($search !== '') {
    $like = "%$search%";
    $countStmt = $baglanti->prepare("
        SELECT COUNT(*) 
        FROM complaints 
        JOIN users ON complaints.user_id = users.id
        WHERE reason LIKE ? 
        OR description LIKE ? 
        OR ad_id LIKE ? 
        OR users.first_name LIKE ? 
        OR users.last_name LIKE ? 
        OR users.email LIKE ?
    ");
    $countStmt->execute([$like, $like, $like, $like, $like, $like]);
} else {
    $countStmt = $baglanti->query("
        SELECT COUNT(*) 
        FROM complaints 
        JOIN users ON complaints.user_id = users.id
    ");
}
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);

// Kayıtları getir
if ($search !== '') {
    $stmt = $baglanti->prepare("
        SELECT complaints.*, users.first_name, users.last_name, users.email, users.phone 
        FROM complaints 
        JOIN users ON complaints.user_id = users.id
        WHERE reason LIKE ? 
        OR description LIKE ? 
        OR ad_id LIKE ? 
        OR users.first_name LIKE ? 
        OR users.last_name LIKE ? 
        OR users.email LIKE ?
        ORDER BY complaints.created_at DESC 
        LIMIT $limit OFFSET $offset
    ");
    $stmt->execute([$like, $like, $like, $like, $like, $like]);
} else {
    $stmt = $baglanti->prepare("
        SELECT complaints.*, users.first_name, users.last_name, users.email, users.phone 
        FROM complaints 
        JOIN users ON complaints.user_id = users.id
        ORDER BY complaints.created_at DESC 
        LIMIT $limit OFFSET $offset
    ");
    $stmt->execute();
}
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4 my-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-dark d-lg-none me-2" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="mb-0"><i class="bi bi-flag-fill me-2"></i> Şikayətlər</h4>
        </div>
    </div>

    <!-- Arama Formu -->
    <form method="get" class="row g-2 mb-4">
        <div class="col-10 col-sm-11">
            <input type="text" name="search" class="form-control" placeholder="İlan ID, səbəb, açıklama ya da istifadəçi ilə axtarın..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-2 col-sm-1 d-grid">
            <button class="btn btn-sm btn-primary" type="submit" title="Axtar">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    <!-- Tablo -->
    <!-- Masaüstü için tablo -->
<div class="d-none d-md-block">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-borderless">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Elan ID</th>
                    <th>Səbəb</th>
                    <th>Açıqlama</th>
                    <th>İstifadəçi</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Tarix</th>
                    <th class="text-end">Əməliyyat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><?= $complaint['id'] ?></td>
                        <td><a href="http://localhost:3000/pages/adsdetail/adsdetail.php?id=<?= $complaint['ad_id'] ?>" target="_blank"><?= $complaint['ad_id'] ?></a></td>
                        <td><?= htmlspecialchars($complaint['reason']) ?></td>
                        <td><?= htmlspecialchars($complaint['description']) ?></td>
                        <td><?= htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']) ?></td>
                        <td><?= htmlspecialchars($complaint['email']) ?></td>
                        <td><?= htmlspecialchars($complaint['phone']) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($complaint['created_at'])) ?></td>
                        <td class="text-end">
                            <a href="?delete=<?= $complaint['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu şikayəti silmək istədiyinizə əminsiniz?')">
                                <i class="bi bi-trash"></i> Sil
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Mobil için kart görünümü -->
<div class="d-md-none">
    <?php foreach ($complaints as $complaint): ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2">#<?= $complaint['id'] ?> — Elan ID: <a href="http://localhost:3000/pages/adsdetail/adsdetail.php?id=<?= $complaint['ad_id'] ?>" target="_blank"><?= $complaint['ad_id'] ?></a></h6>
                <p class="mb-1"><strong>Səbəb:</strong> <?= htmlspecialchars($complaint['reason']) ?></p>
                <p class="mb-1"><strong>Açıqlama:</strong> <?= htmlspecialchars($complaint['description']) ?></p>
                <p class="mb-1"><strong>İstifadəçi:</strong> <?= htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']) ?></p>
                <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($complaint['email']) ?></p>
                <p class="mb-1"><strong>Telefon:</strong> <?= htmlspecialchars($complaint['phone']) ?></p>
                <p class="mb-2 text-muted"><small><i class="bi bi-clock"></i> <?= date('d.m.Y H:i', strtotime($complaint['created_at'])) ?></small></p>
                <a href="?delete=<?= $complaint['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu şikayəti silmək istədiyinizə əminsiniz?')">
                    <i class="bi bi-trash"></i> Sil
                </a>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($complaints)): ?>
        <div class="alert alert-warning text-center">Heç bir şikayət tapılmadı.</div>
    <?php endif; ?>
</div>

    <!-- Sayfalama -->
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
