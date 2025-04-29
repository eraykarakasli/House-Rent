<?php
include "../../tema/includes/header/header.php";
include "../../tema/includes/config.php";

// Slug parametresi alınıyor
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
if (empty($slug)) {
    echo "<div class='container my-5'><p class='text-danger'>Səhifə tapılmadı.</p></div>";
    include "../../tema/includes/footer/footer.php";
    exit;
}

// Veritabanından slug'a göre sayfa çek
$stmt = $baglanti->prepare("SELECT * FROM static_pages WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
    echo "<div class='container my-5'><p class='text-danger'>Bu səhifə mövcud deyil.</p></div>";
    include "../../tema/includes/footer/footer.php";
    exit;
}

// HTML düzeltici
function fixHtmlContent($html) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    return $doc->saveHTML();
}
?>

<!-- İçerik Bölümü -->
<div class="container my-5 min-vh-100">
    <div class="row justify-content-center">
        <div class="col-12 col-md-11 col-lg-10">
            <h2 class="mb-5 text-center fw-bold fs-1"><?= htmlspecialchars($page['title']) ?></h2>

            <div class="post-content fs-5 lh-lg">
                <?= fixHtmlContent($page['content']) ?>
            </div>
        </div>
    </div>
</div>

<!-- İçerik düzenleme stili -->
<style>
    .post-content {
        overflow-wrap: break-word;
        word-wrap: break-word;
        isolation: isolate;
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
