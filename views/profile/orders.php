<div class="container py-5">
    <div class="row">
        <div class="col-md-4 col-lg-3 mb-4">
            <?php
            $active_tab = 'orders';
            require BASE_PATH . '/views/partials/profile/sidebar.php';
            ?>
        </div>

        <div class="col-md-8 col-lg-9">
            <h2 class="mb-4">Moje zamówienia</h2>

            <?php if (empty($orders)): ?>
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Nie masz jeszcze żadnych zamówień</h5>
                        <p class="text-muted">Twoja historia zakupów jest pusta. Czas to zmienić!</p>
                        <a href="index.php?page=home" class="btn btn-primary mt-2">Przejdź do sklepu</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <div>
                                <span class="fw-bold mb-0">Zamówienie #<?= htmlspecialchars($order['id']) ?></span>
                                <small class="text-muted ms-2"><?= date('d.m.Y', strtotime($order['created_at'])) ?></small>
                            </div>
                            <span class="badge bg-<?= $order['status'] === 'ZREALIZOWANE' ? 'success' : 'info' ?>">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-8 mb-2 mb-sm-0">
                                    <p class="mb-0 text-muted">Wartość zamówienia:</p>
                                    <h5 class="mb-0 fw-bold"><?= number_format($order['total_amount'], 2, ',', ' ') ?> zł</h5>
                                </div>
                                <div class="col-sm-4 text-sm-end">
                                    <a href="index.php?page=order_details&id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">Szczegóły</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
