<?php
include 'config.php';

// Site ayarlarını çek
$stmt = $baglanti->prepare("SELECT * FROM site_settings WHERE id = 1");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$siteTitle = $settings['sayt_basliq'] ?? 'Ev Sistemi';
$faviconPath = '../' . ($settings['favicon'] ?? 'assets/icon.png'); // fallback
?>
<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel | <?= htmlspecialchars($siteTitle) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= htmlspecialchars($faviconPath) ?>" type="image/x-icon">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Özel Stil -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
</head>


<body class="bg-light">
    <div class="d-flex">
        