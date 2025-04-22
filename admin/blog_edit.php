<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    echo "<div class='alert alert-danger m-4'>Blog ID yanlışdır.</div>";
    include './includes/footer.php';
    exit;
}

// Blogu çek
$stmt = $baglanti->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    echo "<div class='alert alert-warning m-4'>Belə bir blog tapılmadı.</div>";
    include './includes/footer.php';
    exit;
}

$message = '';
if (isset($_POST['update_blog'])) {
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $is_published = $_POST['is_published'] == 1 ? 1 : 0;

    $image_path = $blog['image']; // varsayılan mevcut görsel
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = 'assets/uploads/blogs/';
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // eski görseli sil
            if ($blog['image'] && file_exists($blog['image'])) {
                unlink($blog['image']);
            }
            $image_path = $target_path;
        } else {
            $message = "<div class='alert alert-danger'>❌ Şəkil yüklənə bilmədi.</div>";
        }
    }

    if (empty($message) && !empty($title)) {
        $stmt = $baglanti->prepare("UPDATE blogs SET title=?, content=?, image=?, is_published=? WHERE id=?");
        $stmt->execute([$title, $content, $image_path, $is_published, $id]);
        header("Location: blogs.php?status=updated");
        exit;
    }
}
?>

<div class="container my-5">
    <h4 class="mb-4">Blog Yazısını Düzəlt</h4>
    <?php if (!empty($message)) echo $message; ?>

    <form method="post" enctype="multipart/form-data" class="row g-4" style="max-width: 700px;">
        <div class="col-12">
            <label class="form-label">Başlıq</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($blog['title']) ?>" required>
        </div>

        <div class="col-12">
            <label class="form-label">Hazırkı Şəkil</label><br>
            <?php if ($blog['image'] && file_exists($blog['image'])): ?>
                <img src="<?= $blog['image'] ?>" class="img-thumbnail mb-2" width="200">
            <?php else: ?>
                <p class="text-muted">Şəkil yoxdur.</p>
            <?php endif; ?>
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <div class="col-12">
            <label class="form-label">Yayın Durumu</label>
            <select name="is_published" class="form-select">
                <option value="1" <?= $blog['is_published'] ? 'selected' : '' ?>>Yayında</option>
                <option value="0" <?= !$blog['is_published'] ? 'selected' : '' ?>>Qaralama</option>
            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Blog Mətni</label>
            <textarea name="content" id="content" class="form-control" rows="6"><?= htmlspecialchars($blog['content']) ?></textarea>
        </div>

        <div class="col-12">
            <button type="submit" name="update_blog" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Yadda Saxla
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#content').summernote({
            height: 250,
            placeholder: 'Blog mətnini buraya yazın...'
        });
    });
</script>

<?php include './includes/footer.php'; ?>
