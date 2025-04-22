<?php
include 'config.php';

$username = 'admin';
$password = 'admin123';

// admin zaten var mı?
$stmt = $baglanti->prepare("SELECT COUNT(*) FROM admin_users WHERE username = ?");
$stmt->execute([$username]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $insert = $baglanti->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
    $insert->execute([$username, $hashed]);
    echo "✅ Admin hesabı yaradıldı: <b>$username</b>";
} else {
    echo "⚠️ Admin artıq mövcuddur: <b>$username</b>";
}
?>
