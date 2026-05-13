<div class="container py-5">
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <?php require BASE_PATH . '/views/partials/profile/sidebar.php'; ?>
        </div>

        <div class="col-md-8 col-lg-9">
            <h2 class="mb-4">Przegląd konta</h2>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 36px;">
                        <?= strtoupper(substr(e($user['first_name']), 0, 1)) ?>
                    </div>
                    <h4>Cześć, <?= e($user['first_name']) ?>!</h4>
                    <p class="text-muted">Z tego poziomu możesz zarządzać swoim kontem, sprawdzić status zamówień i edytować adresy wysyłkowe.</p>
                </div>
            </div>

        </div>
    </div>
</div>
