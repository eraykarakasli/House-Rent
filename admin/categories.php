<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$message = '';

// Yeni kategori ekleme
if (isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    $order_num = (int) $_POST['order_num'];

    if (!empty($category_name)) {
        try {
            $stmt = $baglanti->prepare("INSERT INTO categories (name, order_num) VALUES (?, ?)");
            $stmt->execute([$category_name, $order_num]);
            header("Location: categories.php?status=added");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "<div class='alert alert-warning'>❗ Bu sıra nömrəsi artıq istifadə olunur.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Xəta baş verdi: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }
}

// Sıra numarası güncelleme
if (isset($_POST['update_order'])) {
    $id = (int) $_POST['category_id'];
    $new_order = (int) $_POST['new_order_num'];

    try {
        $stmt = $baglanti->prepare("UPDATE categories SET order_num = ? WHERE id = ?");
        $stmt->execute([$new_order, $id]);
        header("Location: categories.php?status=order_updated");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "<div class='alert alert-warning'>❗ Bu sıra nömrəsi artıq istifadə olunur.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Xəta baş verdi: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}

// Silme işlemi
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $baglanti->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: categories.php?status=deleted");
    exit;
}


$categories = $baglanti->query("SELECT * FROM categories ORDER BY order_num ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">🆕 Yeni Kateqoriya Əlavə Et</h5>

                    <?= $message ?>

                    <?php if (isset($_GET['status'])): ?>
                        <?php if ($_GET['status'] == 'added'): ?>
                            <div class="alert alert-success">✅ Kateqoriya əlavə edildi.</div>
                        <?php elseif ($_GET['status'] == 'deleted'): ?>
                            <div class="alert alert-danger">🗑️ Kateqoriya silindi.</div>
                        <?php elseif ($_GET['status'] == 'order_updated'): ?>
                            <div class="alert alert-info">🔁 Sıra nömrəsi güncəlləndi.</div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Kateqoriya Adı</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Məs: Ailə evi" required>
                        </div>
                        <div class="mb-3">
                            <label for="order_num" class="form-label">Sıra Nömrəsi</label>
                            <input type="number" name="order_num" id="order_num" class="form-control" value="0" min="0" required>
                        </div>
                        <button type="submit" name="add_category" class="btn btn-success px-4">
                            <i class="bi bi-plus-circle me-1"></i> Əlavə et
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kategori listesi -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">📋 Mövcud Kateqoriyalar</h5>
                    <?php if (count($categories) > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($categories as $cat): ?>
                                <li class="list-group-item py-3 px-3">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($cat['name']) ?></h6>
                                            <form method="post" class="d-flex align-items-center gap-2 mt-1">
                                                <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                                                <label class="form-label mb-0 me-2">Sıra nömrəsi</label>
                                                <input type="number" name="new_order_num" value="<?= $cat['order_num'] ?>"
                                                    class="form-control form-control-sm" style="width: 80px;" min="0" required>
                                                <button type="submit" name="update_order" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <a href="?delete=<?= $cat['id'] ?>"
                                                onclick="return confirm('Bu kateqoriya silinsin?')"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Sil
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Hələ heç bir kateqoriya əlavə edilməyib.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>