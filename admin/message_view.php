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

// Mesaj ve kullanıcıyı getir
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
        <h4 class="mb-0"><i class="bi bi-chat-quote me-2"></i> Mesaj Detalları</h4>
      </div>
    </div>

    <div class="card shadow-sm rounded-4">
      <div class="card-body">

        <!-- Kullanıcı Bilgileri -->
        <div class="mb-4">
          <h6><i class="bi bi-person-fill me-2"></i> İstifadəçi Məlumatları:</h6>
          <?php if (!empty($message['first_name'])): ?>
            <p><strong>Adı:</strong> <?= htmlspecialchars($message['first_name'] . ' ' . $message['last_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
            <p><strong>Telefon:</strong> <?= htmlspecialchars($message['phone']) ?></p>
          <?php else: ?>
            <p class="text-danger">İstifadəçi silinmişdir.</p>
          <?php endif; ?>
        </div>

        <hr>

        <h5 class="card-title"><?= htmlspecialchars($message['subject']) ?></h5>
        <p class="text-muted"><?= date('d.m.Y H:i', strtotime($message['created_at'])) ?></p>

        <hr>

        <h6><i class="bi bi-envelope-open me-2"></i> Mesaj:</h6>
        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>

        <!-- Cevap -->
        <?php if (!empty($message['reply'])): ?>
          <hr>
          <h6 class="text-success"><i class="bi bi-reply me-2"></i> Cavab:</h6>
          <p><?= nl2br(htmlspecialchars($message['reply'])) ?></p>
          <p class="text-muted small">Cavab Tarixi: <?= date('d.m.Y H:i', strtotime($message['replied_at'])) ?></p>
        <?php else: ?>
          <hr>
          <p class="text-danger">Bu mesaja hələ cavab verilməyib.</p>
        <?php endif; ?>

        <div class="mt-4">
          <a href="messages.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Geri Qayıt
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include './includes/footer.php'; ?>
