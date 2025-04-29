<?php
include "../../tema/includes/header/header.php";
include "../../tema/includes/config.php";

// Terms verisini çek
$stmt = $baglanti->prepare("SELECT terms FROM site_settings WHERE id = 1 LIMIT 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$terms_content = $row ? $row['terms'] : '<p>İstifadəçi razılaşması tapılmadı.</p>';
?>


<?php include "../../tema/includes/header/header.php"; ?>

<div class="container my-5 min-vh-100">
    <h2 class="text-center fw-bold mb-4 fs-2">İstifadəçi Razılaşması</h2>
    <iframe
        id="termsIframe"
        srcdoc='<?= htmlspecialchars($terms_content, ENT_QUOTES, "UTF-8") ?>'
        style="width: 100%; border: none; overflow: hidden;"
        frameborder="0"
        scrolling="no">
    </iframe>
</div>

<script>
    // İframe içeriği yüklendiğinde yüksekliğini ayarla
    window.addEventListener('DOMContentLoaded', function() {
        const iframe = document.getElementById('termsIframe');
        iframe.onload = function() {
            try {
                const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
                iframe.style.height = iframeDocument.body.scrollHeight + "px";
            } catch (e) {
                console.error("Iframe yüksekliği ayarlanamadı:", e);
            }
        };
    });
</script>

<?php include "../../tema/includes/footer/footer.php"; ?>