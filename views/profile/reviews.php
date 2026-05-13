<div class="container py-5">
    <div class="row">
        <div class="col-md-4 col-lg-3 mb-4">
            <?php
            $active_tab = 'reviews';
            require BASE_PATH . '/views/partials/profile/sidebar.php';
            ?>
        </div>

        <div class="col-md-8 col-lg-9">
            <h2 class="mb-4">Moje opinie</h2>

            <?php if (empty($reviews)): ?>
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-star-half text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Nie oceniłeś jeszcze żadnych produktów</h5>
                        <p class="text-muted">Podziel się swoją opinią o zakupionych produktach i pomóż innym w wyborze!</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="card-title mb-0 fw-bold text-primary">
                                    <a href="index.php?page=product&id=<?= $review['product_id'] ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($review['product_name']) ?>
                                    </a>
                                </h5>
                                <span class="text-muted small"><?= date('d.m.Y', strtotime($review['created_at'])) ?></span>
                            </div>

                            <div class="mb-2 text-warning">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>

                            <p class="card-text text-muted">"<?= htmlspecialchars($review['content']) ?>"</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
