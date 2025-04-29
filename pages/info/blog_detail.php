<?php
include "../../tema/includes/header/header.php";
include "../../tema/includes/config.php";

// ID kontrolü
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "<div class='container my-5'><p class='text-danger'>Məqalə tapılmadı.</p></div>";
    include "../../tema/includes/footer/footer.php";
    exit;
}

// Veritabanından içerik çek
$query = $baglanti->prepare("SELECT * FROM blogs WHERE id = ? AND is_published = 1");
$query->execute([$id]);
$post = $query->fetch(PDO::FETCH_ASSOC);

// İçerik bulunamazsa
if (!$post) {
    echo "<div class='container my-5'><p class='text-danger'>Məqalə mövcud deyil və ya yayımlanmamışdır.</p></div>";
    include "../../tema/includes/footer/footer.php";
    exit;
}

// 💡 Summernote içeriğini düzelten fonksiyon
function fixHtmlContent($html) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    // HTML5 etiket sorunlarını engellemek için XML encoding ekliyoruz
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    return $doc->saveHTML();
}
?>

<!-- Makale Detay Sayfası -->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Başlık ve Tarih -->
            <h1 class="fw-bold mb-3"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="text-muted mb-4">Yayımlanma tarixi: <?= date("d.m.Y", strtotime($post['created_at'])) ?></p>

            <!-- Öne Çıkan Görsel -->
            <img src="../../admin/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded mb-4" alt="<?= htmlspecialchars($post['title']) ?>">

            <!-- İçerik -->
            <div class="post-content fs-5 lh-lg">
                <?= fixHtmlContent($post['content']) ?>
            </div>
        </div>
    </div>
</section>

<!-- Summernote içeriği için özel stil -->
<style>
    .post-content {
        overflow-wrap: break-word;
        word-wrap: break-word;
        isolation: isolate; /* Footer'ın içine taşmayı engeller */
    }

    .post-content * {
        max-width: 100%;
        box-sizing: border-box;
    }

    .post-content img,
    .post-content iframe,
    .post-content video {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1rem 0;
    }

    .post-content table {
        width: 100%;
        display: block;
        overflow-x: auto;
    }

    .post-content ul, .post-content ol {
        padding-left: 1.5rem;
    }

    .post-content blockquote {
        padding: 1rem;
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
        margin: 1rem 0;
    }
</style>

<?php include "../../tema/includes/footer/footer.php"; ?>
