<?php
include "../../tema/includes/session_check.php";
include "../../tema/includes/config.php";
include "../../tema/includes/header/header.php";
?>
<div class="container min-vh-100 my-5">
    <div class="row">
        <!-- Sidebar -->
        <?php include "../../tema/profile/sidebar/profilesidebar.php"; ?>

        <!-- Sağ Panel -->
        <div class="col-12 col-md-8 col-lg-9">
            <!-- Sayfa Başlığı -->
            <div class="row shadow-sm border rounded-4 p-4 mb-4">
                <h4 class="fw-semibold mb-0">Mesajlarım</h4>
            </div>

            <!-- Mesajlar Listesi -->
            <div class="row shadow-sm border rounded-4 p-4">
    <?php
    $user_id = $_SESSION['user_id'];

    // Pagination
    $limit = 5;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Toplam mesaj
    $total_stmt = $baglanti->prepare("SELECT COUNT(*) FROM messages WHERE user_id = ?");
    $total_stmt->execute([$user_id]);
    $total_messages = $total_stmt->fetchColumn();

    // Mesajlar
    $stmt = $baglanti->prepare("SELECT * FROM messages WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $limit, PDO::PARAM_INT);
    $stmt->bindValue(3, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($messages):
        foreach ($messages as $msg):
    ?>
        <div class="mb-3 p-2 border rounded-4 bg-light text-dark">
            <h6 class="fw-semibold mb-2"><i class="bi bi-chat-left-text me-2"></i> <?= htmlspecialchars($msg['subject']) ?></h6>
            <p class="small mb-2"><strong>Mesaj:</strong> <?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <?php if ($msg['reply']): ?>
                <div class="p-2 bg-primary text-white rounded-4 small mt-2">
                    <strong>İdarəçinin cavabı:</strong><br>
                    <?= nl2br(htmlspecialchars($msg['reply'])) ?>
                </div>
            <?php else: ?>
                <div class="mt-2 text-muted small">Hələ cavab verilməyib...</div>
            <?php endif; ?>
        </div>
    <?php
        endforeach;
    else:
        echo "<p class='text-muted'>Hələ heç bir mesajınız yoxdur.</p>";
    endif;
    ?>
</div>


            <!-- Sayfalama -->
            <?php
            $total_pages = ceil($total_messages / $limit);
            if ($total_pages > 1):
            ?>
                <nav aria-label="Mesajlarım səhifələmə" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include "../../tema/includes/footer/footer.php"; ?>
