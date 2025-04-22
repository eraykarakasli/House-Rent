<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Türkçe karakterleri temizleyen slug fonksiyonu
function generateSlug($title, $baglanti)
{
    // Türkçe karakterleri dönüştür
    $turkce = ['ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'];
    $ingilizce = ['s','s','i','i','g','g','u','u','o','o','c','c'];
    $title = str_replace($turkce, $ingilizce, $title);

    // Diğer işlemler
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
    $slug = trim($slug, '-');

    // Aynı slug varsa -2, -3... ekle
    $baseSlug = $slug;
    $i = 1;
    while (true) {
        $check = $baglanti->prepare("SELECT COUNT(*) FROM static_pages WHERE slug = ?");
        $check->execute([$slug]);
        if ($check->fetchColumn() == 0) break;
        $slug = $baseSlug . '-' . $i;
        $i++;
    }
    return $slug;
}

$message = '';

if (isset($_POST['create_page'])) {
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $slug = generateSlug($title, $baglanti); // Slug otomatik ve dönüştürülmüş

    $stmt = $baglanti->prepare("INSERT INTO static_pages (title, slug, content) VALUES (?, ?, ?)");
    $stmt->execute([$title, $slug, $content]);

    header("Location: static_pages.php?status=created");
    exit;
}
?>

<div class="container-fluid px-4 my-5">
    <h4 class="mb-4 text-center"><i class="bi bi-plus-circle me-2"></i>Yeni Statik Səhifə Əlavə Et</h4>

    <?= $message ?>

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm rounded-4 p-4 bg-white">
                <form method="post" class="row g-4">
                    <div class="col-12">
                        <label class="form-label">Səhifə Başlığı</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Məzmun</label>
                        <textarea name="content" id="contentEditor" class="form-control" rows="8"></textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" name="create_page" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Yadda Saxla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summernote -->
<script>
    $(document).ready(function() {
        $('#contentEditor').summernote({
            height: 300,
            placeholder: 'Səhifə məzmununu buraya yazın...'
        });
    });
</script>

<?php include './includes/footer.php'; ?>
