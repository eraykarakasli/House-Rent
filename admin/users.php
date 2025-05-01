<?php
ob_start();
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Arama
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Kullanıcı sorgusu
$sql = "SELECT * FROM users";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE first_name LIKE :s OR last_name LIKE :s OR email LIKE :s";
    $params[':s'] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";
$stmt = $baglanti->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex-grow-1 position-relative" id="main-content">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="mb-0"><i class="bi bi-people-fill me-2"></i> İstifadəçilər</h4>
            </div>
        </div>

        <!-- Arama Çubuğu -->
        <div class="mb-4">
            <form method="get" class="w-100">
                <div class="input-group">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Ad, soyad və ya e-poçt axtar...">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'unbanned'): ?>
            <div class="alert alert-success">✅ İstifadəçinin banı qaldırıldı.</div>
        <?php endif; ?>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'banned'): ?>
            <div class="alert alert-warning">🚫 İstifadəçi uğurla bloklandı.</div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Ad Soyad</th>
                        <th>E-poçt</th>
                        <th>Telefon</th>
                        <th>Qeydiyyat</th>
                        <th class="text-end">Əməliyyat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="text-muted">#<?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                            <td class="text-end">
                                <?php if (!isset($user['is_banned']) || !$user['is_banned']): ?>
                                    <a href="ban_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu istifadəçini bloklamaq istəyirsiniz?')">
                                        <i class="bi bi-person-x"></i> Banla
                                    </a>
                                <?php else: ?>
                                    <a href="unban_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-success" onclick="return confirm('Bu istifadəçinin banını qaldırmaq istəyirsiniz?')">
                                        <i class="bi bi-person-check"></i> Unban
                                    </a>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">👤 Heç bir istifadəçi tapılmadı.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>