<?php
include './includes/session_check.php';
include './includes/config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // Sayfa varsa sil
    $stmt = $baglanti->prepare("DELETE FROM static_pages WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: static_pages.php?status=deleted");
exit;
?>
