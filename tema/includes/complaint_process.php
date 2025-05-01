<?php
session_name('user_session');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /pages/auth/login.php");
    exit;
}

include_once __DIR__ . "/../../tema/includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = isset($_POST['ad_id']) ? (int)$_POST['ad_id'] : 0;
    $reason = trim($_POST['reason'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['user_id']; // user_id session'dan alınır

    if ($ad_id && $reason && $user_id) {
        $stmt = $baglanti->prepare("INSERT INTO complaints (ad_id, user_id, reason, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$ad_id, $user_id, $reason, $description]);

        header("Location: /pages/adsdetail/adsdetail.php?id=" . $ad_id . "&complaint=success");
        exit;
    } else {
        header("Location: /pages/adsdetail/adsdetail.php?id=" . $ad_id . "&complaint=error");
        exit;
    }
} else {
    header("Location: /");
    exit;
}
