<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Arama & filtre & sayfalama
$search = trim($_GET['search'] ?? '');
$filter = $_GET['filter'] ?? 'all';
$page = max(1, (int) ($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

// Toplam kayıt sayısı
$countQuery = "SELECT COUNT(*) FROM messages m LEFT JOIN users u ON m.user_id = u.id WHERE 1";
$params = [];

if ($search) {
    $countQuery .= " AND (u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR m.subject LIKE ?)";
    $params = array_fill(0, 4, "%$search%");
}

if ($filter === 'answered') {
    $countQuery .= " AND m.reply IS NOT NULL";
} elseif ($filter === 'unanswered') {
    $countQuery .= " AND m.reply IS NULL";
}

$countStmt = $baglanti->prepare($countQuery);
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);

// Verileri çek
$dataQuery = "
    SELECT m.*, u.first_name, u.last_name, u.email 
    FROM messages m 
    LEFT JOIN users u ON m.user_id = u.id 
    WHERE 1
";
if ($search) {
    $dataQuery .= " AND (u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR m.subject LIKE ?)";
}
if ($filter === 'answered') {
    $dataQuery .= " AND m.reply IS NOT NULL";
} elseif ($filter === 'unanswered') {
    $dataQuery .= " AND m.reply IS NULL";
}
$dataQuery .= " ORDER BY m.created_at DESC LIMIT $limit OFFSET $offset";

$dataStmt = $baglanti->prepare($dataQuery);
$dataStmt->execute($params);
$messages = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Content -->
<div class="flex-grow-1 position-relative" id="main-content">
  <div class="container-fluid px-3 px-md-4 my-4">

    <!-- Başlık + Menü Butonu -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0"><i class="bi bi-chat-dots me-2"></i> İstifadəçi Mesajları</h4>
      </div>
    </div>

    <!-- Arama ve Filtre -->
    <form method="get" class="row g-3 mb-4">
      <div class="col-12 col-md-8">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Ad, soyad, e-posta və ya başlıq ilə axtar...">
      </div>
      <div class="col-6 col-md-2">
        <select name="filter" class="form-select">
          <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Hamısı</option>
          <option value="answered" <?= $filter === 'answered' ? 'selected' : '' ?>>Cavablanan</option>
          <option value="unanswered" <?= $filter === 'unanswered' ? 'selected' : '' ?>>Cavabsız</option>
        </select>
      </div>
      <div class="col-6 col-md-2">
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Axtar</button>
      </div>
    </form>

    <!-- Mesaj Tablosu -->
    <div class="card shadow-sm rounded-4">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 table-borderless">
            <thead class="table-light">
              <tr>
                <th>#ID</th>
                <th>İstifadəçi</th>
                <th>Başlıq</th>
                <th>Mesaj</th>
                <th>Göndərilmə</th>
                <th>Status</th>
                <th class="text-end">Əməliyyat</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($messages as $msg): ?>
                <tr>
                  <td><?= $msg['id'] ?></td>
                  <td>
                    <?php if (!empty($msg['first_name'])): ?>
                      <?= htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']) ?><br>
                      <small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                    <?php else: ?>
                      <span class="text-danger">İstifadəçi silinib</span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($msg['subject']) ?></td>
                  <td><?= htmlspecialchars(mb_strimwidth($msg['message'], 0, 40, '...')) ?></td>
                  <td><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></td>
                  <td>
                    <?php if (empty($msg['reply'])): ?>
                      <span class="badge bg-danger">Cavabsız</span>
                    <?php else: ?>
                      <span class="badge bg-success">Cavablandı</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-end">
                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                      <?php if (empty($msg['reply'])): ?>
                        <a href="message_reply.php?id=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-warning" title="Cavab Ver">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                      <?php else: ?>
                        <a href="message_view.php?id=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-primary" title="Bax">
                          <i class="bi bi-eye"></i>
                        </a>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (empty($messages)): ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">Heç bir mesaj tapılmadı.</td>
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
        <ul class="pagination justify-content-center flex-wrap">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&filter=<?= urlencode($filter) ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>

  </div>
</div>

<?php include './includes/footer.php'; ?>
