<?php
session_start();
include "../../tema/includes/config.php";

if (!isset($_SESSION['user_id'])) {
    echo "Kullanıcı giriş yapmadı.";
    exit;
}

$userId = $_SESSION['user_id']; 

// Kullanıcının favorilerini al
$stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Favoriler varsa JSON'dan array'e çevir
$favorites = json_decode($user['favorites'] ?? '[]', true);

// Eğer favorilere yeni bir ilan eklenmişse
$adId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$adId) {
    echo "Geçersiz ilan ID'si.";
    exit;
}

// Favorilerde zaten var mı kontrol et
if (in_array($adId, $favorites)) {
    // Favorilerden çıkar
    $favorites = array_diff($favorites, [$adId]);
    $action = 'removed'; 
} else {
    // Favorilere ekle
    $favorites[] = $adId;
    $action = 'added'; 
}

// Favoriler verisini güncelle
$stmt = $baglanti->prepare("UPDATE users SET favorites = ? WHERE id = ?");
$stmt->execute([json_encode(array_values($favorites)), $userId]);

// Favorilerden ekleme veya çıkarma işlemi tamamlandıktan sonra geri yönlendir
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
