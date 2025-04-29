<?php
session_start();
include __DIR__ . "/config.php";
include __DIR__ . "/session_check.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

$adId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = $_SESSION['user_id'];

if ($adId > 0) {
    // Bu ilana sadece ilan sahibi erişebilsin
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE id = ? AND user_id = ?");
    $stmt->execute([$adId, $userId]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ad) {
        // Görsel silme (isteğe bağlı)
        $images = json_decode($ad['images'], true);
        if (is_array($images)) {
            foreach ($images as $img) {
                $filePath = __DIR__ . "/../../" . $img;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Veritabanından ilanı sil
        $delete = $baglanti->prepare("DELETE FROM ads WHERE id = ? AND user_id = ?");
        $delete->execute([$adId, $userId]);

        header("Location: /pages/profile/profileads.php?deleted=success");
        exit;
    } else {
        // İlan yoksa veya başka kullanıcıya aitse
        header("Location: /pages/profile/profileads.php?deleted=unauthorized");
        exit;
    }
} else {
    header("Location: /pages/profile/profileads.php?deleted=invalid");
    exit;
}
?>
