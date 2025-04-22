<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Blogları çek
$blogs = $baglanti->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Blog Yazıları</h4>
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

                    <!-- Yayın durumu etiketi -->
                    <span class="badge position-absolute top-0 start-0 m-2 
                    <?= $blog['is_published'] ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $blog['is_published'] ? 'Yayında' : 'Qaralama' ?>
                    </span>

                    <!-- Görsel -->
                    <div style="height: 160px; overflow: hidden;">
                        <img src="<?= $imageExists ? $imagePath : '/assets/img/default.jpg' ?>"
                            class="w-100 h-100 object-fit-cover rounded-top"
                            alt="Blog şəkli">
                    </div>

                    <!-- İçerik -->
                    <div class="card-body px-3 pt-3 pb-2">
                        <h6 class="card-title mb-1 fw-semibold"><?= htmlspecialchars($blog['title']) ?></h6>
                        <p class="text-muted small mb-0">
                            <?= date('d.m.Y', strtotime($blog['created_at'])) ?> ·
                            <span class="<?= $blog['is_published'] ? 'text-success' : 'text-danger' ?>">
                                <?= $blog['is_published'] ? 'Yayındadır' : 'Yayında deyil' ?>
                            </span>
                        </p>
                    </div>

                    <!-- Butonlar -->
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

</div>

<?php include './includes/footer.php'; ?>