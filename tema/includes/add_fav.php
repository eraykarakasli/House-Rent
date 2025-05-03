<?php
// Oturum başlat
session_name('user_session');
session_start();

// Yanıt türü JSON
header('Content-Type: application/json');

// Veritabanı bağlantısı
include "../../tema/includes/config.php";

// Kullanıcı ID'si kontrolü
$userId = $_SESSION['user_id'] ?? null;
$adId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Geçersizlik kontrolü
if (!$userId || !$adId) {
    echo json_encode(['success' => false, 'message' => 'Geçərsiz istifadəçi və ya elan ID-si.']);
    exit;
}

// Kullanıcının favorilerini al
$stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// JSON'dan diziye çevir
$favorites = json_decode($user['favorites'] ?? '[]', true);

// Favori ekle/çıkar işlemi
if (in_array($adId, $favorites)) {
    $favorites = array_diff($favorites, [$adId]);
    $action = 'removed';
} else {
    $favorites[] = $adId;
    $action = 'added';
}

// Veritabanını güncelle
$stmt = $baglanti->prepare("UPDATE users SET favorites = ? WHERE id = ?");
$success = $stmt->execute([json_encode(array_values($favorites)), $userId]);

// JSON yanıt döndür
echo json_encode([
    'success' => $success,
    'action' => $action,
    'id' => $adId
]);
exit;

?>
