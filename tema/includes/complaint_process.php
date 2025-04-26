<?php
include_once __DIR__ . "/../../tema/includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = isset($_POST['ad_id']) ? (int)$_POST['ad_id'] : 0;
    $reason = trim($_POST['reason'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($ad_id && $reason) {
        $stmt = $baglanti->prepare("INSERT INTO complaints (ad_id, reason, description) VALUES (?, ?, ?)");
        $stmt->execute([$ad_id, $reason, $description]);

        // DOĞRU YÖNLENDİRME
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
?>
