<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Mesajları kullanıcı bilgileri ile çek
$stmt = $baglanti->query("
    SELECT m.*, u.first_name, u.last_name, u.email, u.phone 
    FROM messages m 
    LEFT JOIN users u ON m.user_id = u.id 
    ORDER BY m.created_at DESC
");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid px-4 my-5">
    <h4 class="mb-4"><i class="bi bi-chat-dots me-2"></i> İstifadəçi Mesajları</h4>

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>İstifadəçi</th>
                            <th>Başlıq</th>
                            <th>Mesaj</th>
                            <th>Göndərilmə Tarixi</th>
                            <th>Status</th>
                            <th class="text-end">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?= $msg['id'] ?></td>
                                <td>
                                    <?php if (!empty($msg['first_name'])): ?>
                                        <?= htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']) ?><br>
                                        <small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                                    <?php else: ?>
                                        <span class="text-danger">İstifadəçi silinib</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($msg['subject']) ?></td>
                                <td><?= htmlspecialchars(mb_strimwidth($msg['message'], 0, 40, '...')) ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></td>
                                <td>
                                    <?php if (empty($msg['reply'])): ?>
                                        <span class="badge bg-danger">Cavabsız</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Cavablandı</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if (empty($msg['reply'])): ?>
                                        <a href="message_reply.php?id=<?= $msg['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Cavab Ver
                                        </a>
                                    <?php else: ?>
                                        <a href="message_view.php?id=<?= $msg['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Bax
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($messages)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Heç bir mesaj tapılmadı.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>
