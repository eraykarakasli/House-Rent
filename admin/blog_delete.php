<?php
include './includes/session_check.php';
include './includes/config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header("Location: blogs.php?status=invalid");
    exit;
}

// Blogu çek
$stmt = $baglanti->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header("Location: blogs.php?status=notfound");
    exit;
}

// Görsel varsa sil
if ($blog['image'] && file_exists($blog['image'])) {
    unlink($blog['image']);
}

// Veritabanından blogu sil
$stmt = $baglanti->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->execute([$id]);

header("Location: blogs.php?status=deleted");
exit;
?>
