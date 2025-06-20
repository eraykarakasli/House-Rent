<?php
include "../../tema/includes/header/header.php";
include "../../tema/includes/config.php";

// Terms verisini çek
$stmt = $baglanti->prepare("SELECT terms FROM site_settings WHERE id = 1 LIMIT 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$terms_content = $row ? $row['terms'] : '<p>İstifadəçi razılaşması tapılmadı.</p>';

// Summernote HTML düzeltici
function fixHtmlContent($html) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    return $doc->saveHTML();
}
?>

<div class="container my-5 min-vh-100">
    <h2 class="text-center fw-bold mb-4 fs-2">İstifadəçi Razılaşması</h2>
    <div class="post-content fs-5 lh-lg">
        <?= fixHtmlContent($terms_content) ?>
    </div>
</div>

<!-- Stil düzeltmeleri -->
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
