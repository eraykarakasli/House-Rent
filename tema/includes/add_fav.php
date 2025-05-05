<?php
session_name('user_session');
session_start();
include "../../tema/includes/config.php";

// Kullanıcı ve ilan ID kontrolü
$userId = $_SESSION['user_id'] ?? null;
$adId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$userId || !$adId) {
    $response = ['success' => false, 'message' => 'Geçərsiz istifadəçi və ya elan ID-si.'];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Favorileri çek
$stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$favorites = json_decode($user['favorites'] ?? '[]', true);

// Favori işlemi
if (in_array($adId, $favorites)) {
    $favorites = array_values(array_diff($favorites, [$adId]));
    $action = 'removed';
} else {
    $favorites[] = $adId;
    $action = 'added';
}

// Veritabanı güncelle
$stmt = $baglanti->prepare("UPDATE users SET favorites = ? WHERE id = ?");
$success = $stmt->execute([json_encode($favorites), $userId]);

// Cevap dön
header('Content-Type: application/json');
echo json_encode([
    'success' => $success,
    'action' => $action,
    'id' => $adId
]);
exit;
