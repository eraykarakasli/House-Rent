<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

$stmt = $baglanti->prepare("SELECT * FROM site_settings WHERE id = 1");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$siteTitle = $settings['sayt_basliq'] ?? '';
$siteDescription = $settings['sayt_haqqinda'] ?? '';
$faviconPath = $settings['favicon'] ?? '';
$logoPath = $settings['logo'] ?? '';
$terms = $settings['terms'] ?? '';
$phone = $settings['phone'] ?? '';
$email = $settings['email'] ?? '';
$facebook = $settings['facebook'] ?? '';
$instagram = $settings['instagram'] ?? '';

if (isset($_POST['save'])) {
    $siteTitle = $_POST['site_title'];
    $siteDescription = $_POST['site_description'];
    $terms = $_POST['terms'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];

    $uploadDir = realpath(__DIR__ . '/../assets/uploads/') . '/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    if (!empty($_FILES['favicon']['name'])) {
        $faviconName = uniqid() . '_' . $_FILES['favicon']['name'];
        $faviconTmp = $_FILES['favicon']['tmp_name'];
        $faviconPath = 'assets/uploads/' . $faviconName;
        move_uploaded_file($faviconTmp, $uploadDir . $faviconName);
    }

    if (!empty($_FILES['logo']['name'])) {
        $logoName = uniqid() . '_' . $_FILES['logo']['name'];
        $logoTmp = $_FILES['logo']['tmp_name'];
        $logoPath = 'assets/uploads/' . $logoName;
        move_uploaded_file($logoTmp, $uploadDir . $logoName);
    }

    $stmtCheck = $baglanti->prepare("SELECT COUNT(*) FROM site_settings WHERE id = 1");
    $stmtCheck->execute();
    $exists = $stmtCheck->fetchColumn();

    if ($exists) {
        $stmt = $baglanti->prepare("UPDATE site_settings SET sayt_basliq=?, sayt_haqqinda=?, favicon=?, logo=?, terms=?, phone=?, email=?, facebook=?, instagram=? WHERE id=1");
        $result = $stmt->execute([$siteTitle, $siteDescription, $faviconPath, $logoPath, $terms, $phone, $email, $facebook, $instagram]);
    } else {
        $stmt = $baglanti->prepare("INSERT INTO site_settings (id, sayt_basliq, sayt_haqqinda, favicon, logo, terms, phone, email, facebook, instagram) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$siteTitle, $siteDescription, $faviconPath, $logoPath, $terms, $phone, $email, $facebook, $instagram]);
    }

    if ($result) {
        header("Location: admin_settings.php?status=success");
        exit;
    } else {
        $error = true;
    }
}
?>

<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<div class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <!-- Toggle Butonu -->
            <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <h3 class="mb-0">Sayt Ayarları</h3>
        </div>
    </div>


    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">Məlumatlar uğurla yadda saxlanıldı.</div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="row g-4">
        <div class="col-12">
            <label class="form-label">Sayt Başlığı:</label>
            <input type="text" name="site_title" class="form-control" value="<?= htmlspecialchars($siteTitle) ?>" required>
        </div>

        <div class="col-12">
            <label class="form-label">Sayt Description:</label>
            <textarea name="site_description" class="form-control" rows="2" required><?= htmlspecialchars($siteDescription) ?></textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Telefon:</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
        </div>

        <div class="col-12">
            <label class="form-label">E-poçt:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="col-6">
            <label class="form-label">Facebook:</label>
            <input type="text" name="facebook" class="form-control" value="<?= htmlspecialchars($facebook) ?>">
        </div>

        <div class="col-6">
            <label class="form-label">Instagram:</label>
            <input type="text" name="instagram" class="form-control" value="<?= htmlspecialchars($instagram) ?>">
        </div>

        <div class="col-12">
            <label class="form-label">İstifadəçi Razılaşması:</label>
            <textarea name="terms" id="terms" class="form-control"><?= htmlspecialchars($terms) ?></textarea>
        </div>

        <div class="col-12">
            <label class="form-label d-block">Mövcud Favicon:</label>
            <?php if (!empty($faviconPath) && file_exists(__DIR__ . '/../' . $faviconPath)): ?>
                <img src="../<?= $faviconPath ?>" alt="Favicon" class="img-thumbnail mb-2" width="64">
            <?php else: ?>
                <p class="text-muted small fst-italic">Heç bir favicon yüklənməyib.</p>
            <?php endif; ?>
            <input type="file" name="favicon" class="form-control mt-2">
        </div>

        <div class="col-12">
            <label class="form-label d-block">Mövcud Logo:</label>
            <?php if (!empty($logoPath) && file_exists(__DIR__ . '/../' . $logoPath)): ?>
                <img src="../<?= $logoPath ?>" alt="Logo" class="img-thumbnail mb-2" width="120">
            <?php else: ?>
                <p class="text-muted small fst-italic">Heç bir logo yüklənməyib.</p>
            <?php endif; ?>
            <input type="file" name="logo" class="form-control mt-2">
        </div>

        <div class="col-12">
            <button type="submit" name="save" class="btn btn-primary w-100">Yadda Saxla</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#terms').summernote({
            height: 200,
            placeholder: "İstifadəçi razılaşması mətnini buraya yazın..."
        });
    });
</script>

<?php include './includes/footer.php'; ?>