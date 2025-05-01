<?php
include './includes/session_check.php';
include './includes/config.php';

// ID al
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    include './includes/header.php';
    include './includes/sidebar.php';
    echo "<div class='alert alert-danger m-4'>Yanlış mesaj ID-si.</div>";
    include './includes/footer.php';
    exit;
}

// Mesaj ve kullanıcıyı çek
$stmt = $baglanti->prepare("
    SELECT m.*, u.first_name, u.last_name, u.email, u.phone 
    FROM messages m 
    LEFT JOIN users u ON m.user_id = u.id 
    WHERE m.id = ?
");
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {
    include './includes/header.php';
    include './includes/sidebar.php';
    echo "<div class='alert alert-warning m-4'>Mesaj tapılmadı.</div>";
    include './includes/footer.php';
    exit;
}

// Cevap gönderimi
if (isset($_POST['reply_submit'])) {
    $reply = trim($_POST['reply']);
    if (!empty($reply)) {
        $stmt = $baglanti->prepare("UPDATE messages SET reply = ?, replied_at = NOW() WHERE id = ?");
        $stmt->execute([$reply, $id]);
        header("Location: messages.php?status=replied");
        exit;
    } else {
        $error = "Cavab boş ola bilməz.";
    }
}

include './includes/header.php';
include './includes/sidebar.php';
?>

<!-- Main Content -->
<div class="flex-grow-1 position-relative" id="main-content">
  <div class="container-fluid px-3 px-md-4 my-4">
    <!-- Başlık ve Menü Butonu -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0"><i class="bi bi-reply-fill me-2"></i> Mesaja Cavab Ver</h4>
      </div>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm rounded-4">
      <div class="card-body">
        <h6><i class="bi bi-person-fill me-2"></i> İstifadəçi:</h6>
        <?php if (!empty($message['first_name'])): ?>
          <p><strong>Ad:</strong> <?= htmlspecialchars($message['first_name'] . ' ' . $message['last_name']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
          <p><strong>Telefon:</strong> <?= htmlspecialchars($message['phone']) ?></p>
        <?php else: ?>
          <p class="text-danger">İstifadəçi silinmişdir.</p>
        <?php endif; ?>

        <hr>

        <h5 class="card-title"><?= htmlspecialchars($message['subject']) ?></h5>
        <p class="text-muted"><?= date('d.m.Y H:i', strtotime($message['created_at'])) ?></p>
        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>

        <hr>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Cavab</label>
            <textarea name="reply" class="form-control" rows="6" required></textarea>
          </div>

          <button type="submit" name="reply_submit" class="btn btn-success">
            <i class="bi bi-send-check me-1"></i> Cavabı Göndər
          </button>
          <a href="messages.php" class="btn btn-secondary ms-2">Geri Qayıt</a>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include './includes/footer.php'; ?>
