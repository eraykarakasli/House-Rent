<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$limit = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalStmt = $baglanti->query("SELECT COUNT(*) FROM blogs");
$totalPages = ceil($totalStmt->fetchColumn() / $limit);

$stmt = $baglanti->prepare("SELECT * FROM blogs ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0">Blog Yazıları</h4>
    </div>
    <a href="blog_create.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Yeni Blog Əlavə Et
    </a>
</div>

    <div class="row">
        <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <div class="alert alert-danger">🗑️ Blog uğurla silindi.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'invalid'): ?>
            <div class="alert alert-warning">⚠️ Blog ID yanlışdır.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'notfound'): ?>
            <div class="alert alert-info">🔍 Blog tapılmadı.</div>
        <?php endif; ?>

        <?php foreach ($blogs as $blog): ?>
            <?php
            $imagePath = $blog['image'];
            $imageExists = $imagePath && file_exists(__DIR__ . '/' . $imagePath);
            ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded-4 h-100 overflow-hidden position-relative border-0">
                    <span class="badge position-absolute top-0 start-0 m-2 
                    <?= $blog['is_published'] ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $blog['is_published'] ? 'Yayında' : 'Qaralama' ?>
                    </span>
                    <div style="height: 160px; overflow: hidden;">
                        <img src="<?= $imageExists ? $imagePath : '/assets/img/default.jpg' ?>"
                            class="w-100 h-100 object-fit-cover rounded-top"
                            alt="Blog şəkli">
                    </div>
                    <div class="card-body px-3 pt-3 pb-2">
                        <h6 class="card-title mb-1 fw-semibold"><?= htmlspecialchars($blog['title']) ?></h6>
                        <p class="text-muted small mb-0">
                            <?= date('d.m.Y', strtotime($blog['created_at'])) ?> ·
                            <span class="<?= $blog['is_published'] ? 'text-success' : 'text-danger' ?>">
                                <?= $blog['is_published'] ? 'Yayındadır' : 'Yayında deyil' ?>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between px-3 pb-3">
                        <a href="blog_edit.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-warning rounded-pill px-3">
                            <i class="bi bi-pencil"></i> Düzəlt
                        </a>
                        <a href="blog_delete.php?id=<?= $blog['id'] ?>" onclick="return confirm('Silinsin?')" class="btn btn-sm btn-danger rounded-pill px-3">
                            <i class="bi bi-trash"></i> Sil
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
