<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-5">

                <div class="mb-4">
                    <!-- Ikonka sukcesu -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle text-success" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                </div>

                <h1 class="display-5 mb-3">Dziękujemy za zamówienie!</h1>
                <p class="lead text-muted mb-5">
                    Twoje zamówienie zostało pomyślnie złożone (w trybie testowym).
                </p>

                <div class="row text-start mb-4">
                    <div class="col-md-6 mb-3">
                        <h5 class="border-bottom pb-2">Dane dostawy</h5>
                        <?php if ($order['delivery'] === 'pickup'): ?>
                            <p><strong>Odbiór osobisty w salonie</strong></p>
                        <?php elseif ($order['delivery'] === 'paczkomat'): ?>
                            <p><strong>Paczkomat InPost:</strong> <?= e($order['shipping']['paczkomat_code'] ?? '') ?></p>
                            <p><strong>Telefon:</strong> <?= e($order['shipping']['phone'] ?? '') ?></p>
                        <?php else: ?>
                            <p><strong>Kurier:</strong> <?= e($order['shipping']['first_name'] ?? '') ?> <?= e($order['shipping']['last_name'] ?? '') ?></p>
                            <p><?= e($order['shipping']['street'] ?? '') ?></p>
                            <p><?= e($order['shipping']['zip_code'] ?? '') ?> <?= e($order['shipping']['city'] ?? '') ?></p>
                            <p><strong>Telefon:</strong> <?= e($order['shipping']['phone'] ?? '') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5 class="border-bottom pb-2">Płatność i Kwota</h5>
                        <p><strong>Metoda:</strong> <?= e($order['payment']) ?></p>
                        <p><strong>Do zapłaty:</strong> <span class="fs-4 text-primary fw-bold"><?= number_format($order['total'], 2, ',', ' ') ?> zł</span></p>
                    </div>
                </div>

                <a href="index.php" class="btn btn-primary btn-lg mt-3">Wróć na stronę główną</a>
            </div>
        </div>
    </div>
</div>
