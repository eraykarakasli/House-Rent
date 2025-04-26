<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Şikayetleri çek
$stmt = $baglanti->query("SELECT * FROM complaints ORDER BY created_at DESC");
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Silme işlemi
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $baglanti->prepare("DELETE FROM complaints WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: complaints.php");
    exit;
}
?>

<div class="container-fluid px-4 my-5">
    <h4 class="mb-4"><i class="bi bi-flag-fill me-2"></i> Şikayətlər</h4>

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Elan ID</th>
                            <th>Səbəb</th>
                            <th>Açıqlama</th>
                            <th>Şikayət Tarixi</th>
                            <th class="text-end">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($complaints as $complaint): ?>
                            <tr>
                                <td><?= $complaint['id'] ?></td>
                                <td>
                                    <a href="http://localhost:3000/pages/adsdetail/adsdetail.php?id=<?= $complaint['ad_id'] ?>" 
                                       target="_blank" 
                                       class="text-decoration-none" 
                                       title="İlan Detayına Git">
                                        <?= $complaint['ad_id'] ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($complaint['reason']) ?></td>
                                <td><?= htmlspecialchars(mb_strimwidth($complaint['description'], 0, 40, '...')) ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($complaint['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="?delete=<?= $complaint['id'] ?>" onclick="return confirm('Bu şikayəti silmək istədiyinizə əminsiniz?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Sil
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($complaints)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Heç bir şikayət tapılmadı.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>
