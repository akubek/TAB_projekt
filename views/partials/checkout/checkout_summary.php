<div class="card shadow-sm border-0 p-4 sticky-top" style="top: 20px;">
    <h5 class="mb-4">Podsumowanie zamówienia</h5>

    <ul class="list-group list-group-flush mb-4">
        <?php foreach ($items as $item): ?>
            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <!-- Miniaturka z ilością jako "badge" -->
                    <div class="position-relative me-3">
                        <img src="<?= e($item['image']) ?>" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                            <?= $item['quantity'] ?>
                        </span>
                    </div>

                    <!-- Dane produktu (bez linków!) -->
                    <div>
                        <div class="fw-bold" style="font-size: 0.9rem;"><?= e($item['name']) ?></div>
                        <small class="text-muted" style="font-size: 0.8rem;">
                            <?= implode(', ', array_map(fn($k, $v) => e($k) . ': ' . e($v), array_keys($item['attributes']), $item['attributes'])) ?>
                        </small>
                    </div>
                </div>

                <!-- Cena (Suma dla tej pozycji) -->
                <span class="fw-bold" style="font-size: 0.95rem;">
                    <?= number_format($item['subtotal'], 2, ',', ' ') ?> zł
                </span>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <div class="d-flex justify-content-between mb-2">
        <span class="text-muted">Suma częściowa</span>
        <span><?= number_format($totalToPay, 2, ',', ' ') ?> zł</span>
    </div>

    <!-- Tu w przyszłości JS może dorzucić koszty dostawy -->
    <div class="d-flex justify-content-between mb-3" id="shipping-cost-row">
        <span class="text-muted">Dostawa</span>
        <span class="text-success fw-bold" id="shipping-cost-value">0 zł (do wyliczenia)</span>
    </div>

    <div class="d-flex justify-content-between mb-4 fw-bold fs-5 border-top pt-3">
        <span>Do zapłaty</span>
        <span id="final-total"><?= number_format($totalToPay, 2, ',', ' ') ?> zł</span>
    </div>

    <!-- Przycisk przeniesiony z formularza do podsumowania dla lepszego UX -->
    <button type="submit" form="checkout-form" class="btn btn-primary btn-lg w-100">
        Kupuję i płacę
    </button>
</div>
