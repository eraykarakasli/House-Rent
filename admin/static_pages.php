<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$stmt = $baglanti->query("SELECT * FROM static_pages ORDER BY id ASC");
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4 my-5">
    <!-- Status Mesajları -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'created'): ?>
            <div class="alert alert-success">✅ Yeni səhifə uğurla əlavə edildi.</div>
        <?php elseif ($_GET['status'] === 'updated'): ?>
            <div class="alert alert-success">✅ Səhifə uğurla güncəlləndi.</div>
        <?php elseif ($_GET['status'] === 'deleted'): ?>
            <div class="alert alert-danger">🗑️ Səhifə silindi.</div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Başlık ve Buton -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Statik Sayfalar</h4>
        <a href="static_page_create.php" class="btn btn-sm btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Yeni Səhifə Əlavə Et
        </a>
    </div>

    <!-- Tablo Kartı -->
    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Başlıq</th>
                            <th style="width: 25%;">Slug</th>
                            <th style="width: 25%;">Son Yenilənmə</th>
                            <th style="width: 20%;" class="text-end">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $page['id'] ?></td>
                                <td><?= htmlspecialchars($page['title']) ?></td>
                                <td><code><?= htmlspecialchars($page['slug']) ?></code></td>
                                <td><?= date('d.m.Y H:i', strtotime($page['updated_at'])) ?></td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="static_page_edit.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Düzəlt
                                        </a>
                                        <a href="static_page_delete.php?id=<?= $page['id'] ?>"
                                           onclick="return confirm('❗ Bu səhifəni silmək istədiyinizə əminsiniz?')"
                                           class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pages)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">🗒️ Heç bir statik səhifə mövcud deyil.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>
