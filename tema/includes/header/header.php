<?php

include_once __DIR__ . "/../../../tema/includes/config.php";

// Site ayarlarını veritabanından al
$stmt = $baglanti->prepare("SELECT * FROM site_settings ORDER BY id DESC LIMIT 1");
$stmt->execute();
$site = $stmt->fetch(PDO::FETCH_ASSOC);

$site_title = $site['sayt_basliq'] ?? 'title';
$site_favicon = '/' . ltrim($site['favicon'] ?? 'assets/icon.png', '/');
$site_logo = '/' . ltrim($site['logo'] ?? 'assets/icon.png', '/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= htmlspecialchars($site_favicon) ?>" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title><?= htmlspecialchars($site_title) ?></title>
    <meta name="keywords" content="emlak, ev, kiraye, ev alqi satqisi, bakida evler, emlak saytlari, satiliq evler, ev elanlari, kiraye evler, gundelik evler, çıxarışın yoxlanılması, bina az, yeniemlak, yeni emlak, bakida satilan evler, villa evler, vip evler">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom fixed-top" style="min-height: 100px;">
        <div class="container">
            <!-- Sol logo -->
            <a class="navbar-brand d-flex align-items-center" href="../../index.php">
                <img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo" width="48">
                <span class="fw-semibold fs-2" style="color: #0d98ba;"><?= htmlspecialchars($site_title) ?></span>
            </a>
            <!-- Mobil menü butonu -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menü içeriği -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                <!-- Orta Menü -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="/pages/ads/ads.php?category=obyekt">Obyekt</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/ads/ads.php?category=ofis">Ofis</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/ads/ads.php?category=qaraj">Qaraj</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/ads/ads.php?category=torpaq">Torpaq</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/ads/ads.php?category=menzil">Menzil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/ads/ads.php?category=heyet">Həyət evi / Bağ evi</a></li>
                </ul>
                <!-- Sağ Butonlar -->
                <div class="d-flex align-items-center gap-3">
                    <a href="/pages/profile/profileads.php" class="text-dark text-decoration-none d-flex align-items-center gap-1">
                        <i class="bi bi-plus-circle"></i> Elan
                    </a>
                    <div class="position-relative dropdown">
                        <button type="button" data-bs-toggle="dropdown" class="btn btn-outline border rounded-5 d-flex align-items-center gap-2 dropdown-toggle">
                            <i class="bi bi-list"></i> <i class="bi bi-person"></i>
                        </button>
                        <div class="dropdown-menu p-1 py-2 text-center shadow rounded-3" style="min-width: 90px;">
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <!-- Giriş yapılmamışsa: Daxil ol -->
                                <a href="/pages/auth/register.php" class="text-dark text-decoration-none d-block dropdown-item" style="font-size: 14px;">
                                    Daxil Ol
                                </a>
                            <?php else: ?>
                                <!-- Giriş yapılmışsa: Kabinetim ve Seçilmişlər -->
                                <a href="/pages/profile/profile.php" class="text-dark text-decoration-none d-block dropdown-item" style="font-size: 14px;">
                                    Kabinetim
                                </a>
                                <div class="border-bottom"></div>
                                <a href="/pages/profile/profilefavorites.php" class="text-dark text-decoration-none d-block dropdown-item" style="font-size: 14px;">
                                    Seçilmişlər
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div style="margin-top: 120px;"></div>