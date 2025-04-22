<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$message = '';

if (isset($_POST['add_blog'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $is_published = isset($_POST['is_published']) ? (int)$_POST['is_published'] : 0;
    $image_path = null;

    // Görsel yüklendi mi?
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = 'assets/uploads/blogs/';
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = $target_path;
        } else {
            $message = "<div class='alert alert-danger'>❌ Şəkil yüklənə bilmədi.</div>";
        }
    }

    if (empty($message) && !empty($title) && !empty($content)) {
        $stmt = $baglanti->prepare("INSERT INTO blogs (title, content, image, is_published) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $image_path, $is_published]);
        header("Location: blogs.php?status=added");
        exit;
    } else if (empty($content)) {
        $message = "<div class='alert alert-warning'>❗ Blog yazısı boş ola bilməz.</div>";
    }
}
?>

<div class="container my-5">
    <h4 class="mb-4">Yeni Blog Yazısı Əlavə Et</h4>

    <?php if (!empty($message)) echo $message; ?>

    <form method="post" enctype="multipart/form-data" class="row g-4" style="max-width: 800px;">
        <div class="col-12">
            <label for="title" class="form-label">Başlıq</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="col-12">
            <label for="image" class="form-label">Şəkil Yüklə</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="col-12">
            <label for="is_published" class="form-label">Yayın Durumu</label>
            <select name="is_published" id="is_published" class="form-select">
                <option value="1">Yayınla</option>
                <option value="0">Taslak</option>
            </select>
        </div>

        <div class="col-12">
            <label for="content" class="form-label">Blog Mətn</label>
            <textarea id="content" name="content" class="form-control" rows="6"></textarea>
        </div>

        <div class="col-12">
            <button type="submit" name="add_blog" class="btn btn-success">
                <i class="bi bi-upload"></i> Blogu Əlavə Et
            </button>
        </div>
    </form>
</div>

<!-- Summernote JS aktivasyonu -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#content').summernote({
            height: 250
        });
    });
</script>

<?php include './includes/footer.php'; ?>
