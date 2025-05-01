<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalStmt = $baglanti->query("SELECT COUNT(*) FROM static_pages");
$totalPages = ceil($totalStmt->fetchColumn() / $limit);

$stmt = $baglanti->prepare("SELECT * FROM static_pages ORDER BY id ASC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4 my-5">
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'created'): ?>
            <div class="alert alert-success">✅ Yeni səhifə uğurla əlavə edildi.</div>
        <?php elseif ($_GET['status'] === 'updated'): ?>
            <div class="alert alert-success">✅ Səhifə uğurla güncəlləndi.</div>
        <?php elseif ($_GET['status'] === 'deleted'): ?>
            <div class="alert alert-danger">🗑️ Səhifə silindi.</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Statik Sayfalar</h4>
        </div>
        <a href="static_page_create.php" class="btn btn-sm btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Yeni Səhifə Əlavə Et
        </a>
    </div>

    <div class="card shadow-sm rounded-4 d-none d-md-block">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-borderless table-sm">
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

    <div class="d-md-none">
        <?php foreach ($pages as $page): ?>
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">#<?= $page['id'] ?> — <?= htmlspecialchars($page['title']) ?></h6>
                    <p class="mb-1"><strong>Slug:</strong> <code><?= htmlspecialchars($page['slug']) ?></code></p>
                    <p class="mb-1"><strong>Yenilənmə:</strong> <?= date('d.m.Y H:i', strtotime($page['updated_at'])) ?></p>
                    <div class="d-flex justify-content-end gap-2 mt-2">
                        <a href="static_page_edit.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="static_page_delete.php?id=<?= $page['id'] ?>"
                           onclick="return confirm('❗ Bu səhifəni silmək istədiyinizə əminsiniz?')"
                           class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($pages)): ?>
            <div class="text-center text-muted py-4">🗒️ Heç bir statik səhifə mövcud deyil.</div>
        <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include './includes/footer.php'; ?>
