<?php include "../../tema/includes/header/header.php"; 
 include "../../tema/includes/config.php"; 

$query = $baglanti->prepare("SELECT * FROM blogs WHERE is_published = 1 ORDER BY created_at DESC LIMIT 12");
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="container my-5">
    <h2 class="fw-bold fs-3 mb-4">Son məqalələr</h2>
    <div class="row g-4" >

        <?php foreach ($posts as $post): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm position-relative">
                    <img src="../../admin/<?= htmlspecialchars($post['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold"><?= htmlspecialchars($post['title']) ?></h5>
                        <p class="card-text text-muted"><?= mb_strimwidth(strip_tags($post['content']), 0, 100, '...') ?></p>
                        <a href="blog_detail.php?id=<?= $post['id'] ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- Sabit pagination (dilersen dinamik yapabiliriz) -->
    <nav aria-label="Səhifələmə" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link bg-transparent border-0 text-secondary" href="#" tabindex="-1" aria-disabled="true">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
            <li class="page-item active">
                <a class="page-link border rounded-1 border-primary text-primary bg-transparent fw-semibold" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link bg-transparent border-0 rounded-1 text-secondary" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link bg-transparent border-0 rounded-1 text-secondary" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link bg-transparent border-0 rounded-1 text-secondary" href="#">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</section>


<?php include "../../tema/includes/footer/footer.php"; ?>
