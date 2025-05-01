<?php
include $_SERVER['DOCUMENT_ROOT'] . '/tema/includes/session_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/tema/includes/config.php';

$user_id = $_SESSION['user_id'];
$stmt = $baglanti->prepare("SELECT first_name, last_name, profile_photo FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!-- Sol Menü -->
<div class="col-md-4 col-lg-3 mb-3">
    <div class="bg-white shadow-sm rounded-4 p-4 h-100">

        <!-- Kullanıcı bilgisi -->
        <div class="text-center mb-4">
            <img src="<?= !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : '../../assets/proifle.png' ?>"
                width="80" class="rounded-circle mb-2" alt="Profil Resmi">
            <h5 class="fw-semibold mb-0"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h5>
        </div>

        <!-- Menü -->
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center active text-dark  bg-light rounded px-3 py-2" href="profile.php">
                    <div><i class="bi bi-person me-2"></i> Profilim</div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded px-3 py-2" href="profilefavorites.php">
                    <div><i class="bi bi-heart me-2"></i> Seçilmişlər</div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded px-3 py-2" href="profileads.php?page=ads">
                    <div><i class="bi bi-tag me-2"></i> Elanlarım</div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded px-3 py-2" href="profile_contact.php">
                    <div><i class="bi bi-chat-dots me-2"></i> Dəstək</div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded px-3 py-2 " href="profile_messages.php">
                    <div><i class="bi bi-envelope-open me-2"></i>  Mesajlarım</div>
                    <i class="bi bi-chevron-right"></i>
                </a>

            </li>

        </ul>

        <!-- Çıkış -->
        <div class="mt-4 pt-3 border-top">
            <a class="nav-link d-flex justify-content-between align-items-center text-danger fw-semibold rounded px-3 py-2" href="/tema/includes/logout.php">
                <div><i class="bi bi-box-arrow-right me-2"></i> Çıxış</div>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</div>