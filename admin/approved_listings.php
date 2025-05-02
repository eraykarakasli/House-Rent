<?php
ob_start(); 
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Arama ve sayfalama
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Sil
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $baglanti->prepare("DELETE FROM ads WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: approved_listings.php?status=deleted");
    exit;
}

// Öne çıkar
if (isset($_GET['promote'])) {
    $id = (int) $_GET['promote'];
    $stmt = $baglanti->prepare("UPDATE ads SET is_promoted = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: approved_listings.php?status=promoted");
    exit;
}

// Öne çıkarmayı kaldır
if (isset($_GET['unpromote'])) {
    $id = (int) $_GET['unpromote'];
    $stmt = $baglanti->prepare("UPDATE ads SET is_promoted = 0 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: approved_listings.php?status=unpromoted");
    exit;
}

// Onaydan çıkar
if (isset($_GET['unapprove'])) {
    $id = (int) $_GET['unapprove'];
    $stmt = $baglanti->prepare("UPDATE ads SET status = 0 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: approved_listings.php?status=unapproved");
    exit;
}

// Toplam sayfa
if ($search !== '') {
    $searchNumeric = is_numeric($search) ? (int)$search : 0;
    $stmtCount = $baglanti->prepare("SELECT COUNT(*) FROM ads WHERE status = 1 AND (id = ? OR title LIKE ? OR category LIKE ?)");
    $stmtCount->execute([$searchNumeric, "%$search%", "%$search%"]);
} else {
    $stmtCount = $baglanti->query("SELECT COUNT(*) FROM ads WHERE status = 1");
}
$total = $stmtCount->fetchColumn();
$totalPages = ceil($total / $limit);

// Verileri çek
if ($search !== '') {
    $searchNumeric = is_numeric($search) ? (int)$search : 0;
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE status = 1 AND (id = ? OR title LIKE ? OR category LIKE ?) ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
    $stmt->execute([$searchNumeric, "%$search%", "%$search%"]);
} else {
    $stmt = $baglanti->query("SELECT * FROM ads WHERE status = 1 ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
}
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Content -->
<div class="flex-grow-1 position-relative" id="main-content">
  <div class="container-fluid px-3 px-md-4 my-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0"><i class="bi bi-list-check me-2"></i> Təsdiqlənmiş Elanlar</h4>
      </div>
    </div>

    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status'] == 'deleted'): ?>
        <div class="alert alert-danger">🗑️ Elan silindi.</div>
      <?php elseif ($_GET['status'] == 'promoted'): ?>
        <div class="alert alert-success">⭐ Elan öne çıxarıldı.</div>
      <?php elseif ($_GET['status'] == 'unpromoted'): ?>
        <div class="alert alert-warning">📤 Elan öne çıxarılmadan çıxarıldı.</div>
      <?php elseif ($_GET['status'] == 'unapproved'): ?>
        <div class="alert alert-info">⏪ Elan onaydan çıxarıldı.</div>
      <?php endif; ?>
    <?php endif; ?>

    <form method="get" class="mb-4">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="ID, Başlıq və ya Kateqoriya ilə axtar..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Axtar</button>
      </div>
    </form>
    
    <div class="card shadow-sm rounded-4">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 table-borderless text-nowrap">
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
                    <div class="btn-group" role="group">
                      <?php if ($ad['is_promoted']): ?>
                        <a href="?unpromote=<?= $ad['id'] ?>" class="btn btn-sm btn-warning" title="Öne Çıxarılmanı Kaldır">
                          <i class="bi bi-star"></i>
                        </a>
                      <?php else: ?>
                        <a href="?promote=<?= $ad['id'] ?>" class="btn btn-sm btn-success" title="Öne Çıxar">
                          <i class="bi bi-star-fill"></i>
                        </a>
                      <?php endif; ?>
                      <a href="?unapprove=<?= $ad['id'] ?>" class="btn btn-sm btn-secondary" title="Onaydan Çıkar">
                        <i class="bi bi-arrow-counterclockwise"></i>
                      </a>
                      <a href="?delete=<?= $ad['id'] ?>" onclick="return confirm('Bu elanı silmək istədiyinizə əminsiniz?')" class="btn btn-sm btn-danger" title="Sil">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
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
</div>

<?php include './includes/footer.php'; ?>
