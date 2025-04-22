<?php
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';
include './includes/session_check.php';


// Önce mevcut veriyi çek
$stmt = $baglanti->prepare("SELECT * FROM site_ayarlar WHERE id = 1");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$siteTitle = $settings['sayt_basliq'] ?? '';
$siteDescription = $settings['sayt_haqqinda'] ?? '';
$faviconPath = $settings['favicon'] ?? '';
$logoPath = $settings['logo'] ?? '';

if (isset($_POST['save'])) {
    $siteTitle = $_POST['site_title'];
    $siteDescription = $_POST['site_description'];

    // Favicon yükle
    if (!empty($_FILES['favicon']['name'])) {
        $faviconName = uniqid() . '_' . $_FILES['favicon']['name'];
        $faviconTmp = $_FILES['favicon']['tmp_name'];
        $faviconPath = 'assets/uploads/' . $faviconName;
        move_uploaded_file($faviconTmp, $faviconPath);
    }

    // Logo yükle
    if (!empty($_FILES['logo']['name'])) {
        $logoName = uniqid() . '_' . $_FILES['logo']['name'];
        $logoTmp = $_FILES['logo']['tmp_name'];
        $logoPath = 'assets/uploads/' . $logoName;
        move_uploaded_file($logoTmp, $logoPath);
    }

    // Ayar daha önce varsa → UPDATE, yoksa INSERT
    $stmtCheck = $baglanti->prepare("SELECT COUNT(*) FROM site_ayarlar WHERE id = 1");
    $stmtCheck->execute();
    $exists = $stmtCheck->fetchColumn();

    if ($exists) {
        $stmt = $baglanti->prepare("UPDATE site_ayarlar SET sayt_basliq=?, sayt_haqqinda=?, favicon=?, logo=? WHERE id=1");
        $result = $stmt->execute([$siteTitle, $siteDescription, $faviconPath, $logoPath]);
    } else {
        $stmt = $baglanti->prepare("INSERT INTO site_ayarlar (id, sayt_basliq, sayt_haqqinda, favicon, logo) VALUES (1, ?, ?, ?, ?)");
        $result = $stmt->execute([$siteTitle, $siteDescription, $faviconPath, $logoPath]);
    }

    // Sayfa yenileme
    if ($result) {
        header("Location: admin_settings.php?status=success");
        exit;
    } else {
        $error = true;
    }
}
?>

<div class="container-fluid p-4" style="max-width: 720px;">
    <h3 class="mb-4">Sayt Ayarları</h3>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">Məlumatlar uğurla yadda saxlanıldı.</div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="row g-4">
        
        <!-- Site Title -->
        <div class="col-12">
            <label class="form-label">Sayt Başlığı:</label>
            <input type="text" name="site_title" class="form-control" value="<?= htmlspecialchars($siteTitle) ?>" required>
        </div>

        <!-- Site Description -->
        <div class="col-12">
            <label class="form-label">Sayt Haqqında:</label>
            <textarea name="site_description" class="form-control" rows="4" required><?= htmlspecialchars($siteDescription) ?></textarea>
        </div>

        <!-- Favicon -->
        <div class="col-12">
            <label class="form-label d-block">Mövcud Favicon:</label>
            <?php if (!empty($faviconPath) && file_exists($faviconPath)): ?>
                <img src="<?= $faviconPath ?>" alt="Favicon" class="img-thumbnail mb-2" width="64">
            <?php else: ?>
                <p class="text-muted small fst-italic">Heç bir favicon yüklənməyib.</p>
            <?php endif; ?>
            <label class="form-label mt-2">Yeni Favicon Yüklə:</label>
            <input type="file" name="favicon" class="form-control">
        </div>

        <!-- Logo -->
        <div class="col-12">
            <label class="form-label d-block">Mövcud Logo:</label>
            <?php if (!empty($logoPath) && file_exists($logoPath)): ?>
                <img src="<?= $logoPath ?>" alt="Logo" class="img-thumbnail mb-2" width="120">
            <?php else: ?>
                <p class="text-muted small fst-italic">Heç bir logo yüklənməyib.</p>
            <?php endif; ?>
            <label class="form-label mt-2">Yeni Logo Yüklə:</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <!-- Submit -->
        <div class="col-12">
            <button type="submit" name="save" class="btn btn-primary w-100">Yadda Saxla</button>
        </div>
    </form>
</div>



<?php include './includes/footer.php'; ?>