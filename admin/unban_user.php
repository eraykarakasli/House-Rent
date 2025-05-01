<?php
include './includes/session_check.php';
include './includes/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: users.php?status=invalid");
    exit;
}

$userId = (int) $_GET['id'];

// Kullanıcı kontrolü
$stmt = $baglanti->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: users.php?status=notfound");
    exit;
}

// Ban kaldır
$stmt = $baglanti->prepare("UPDATE users SET is_banned = 0 WHERE id = ?");
$stmt->execute([$userId]);

header("Location: users.php?status=unbanned");
exit;
