<?php
include "../../includes/session_check.php";
include "../../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // session'dan kullanıcı id alıyoruz
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (!empty($subject) && !empty($message)) {
        $stmt = $baglanti->prepare("INSERT INTO messages (user_id, subject, message) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $subject, $message]);
        header("Location: /pages/profile/profile_contact.php?success=1");
        exit;
    } else {
        header("Location: /pages/profile/profile_contact.php?error=1");
        exit;
    }
}
