<?php
// views/profile/index.php

// Komunikaty o sukcesie lub błędzie (zmienione na czytelniejsze dla odczytu)
if (isset($_SESSION['profile_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <?= e($_SESSION['profile_success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php unset($_SESSION['profile_success']);
endif; ?>

<?php if (isset($_SESSION['profile_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <?= e($_SESSION['profile_error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php unset($_SESSION['profile_error']);
endif; ?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px; font-size: 48px;">
                        <?= strtoupper(substr(e($user['first_name'] ?? 'U'), 0, 1)); ?>
                    </div>
                </div>
                <h4 class="fw-bold mb-1"><?= e($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                <p class="text-muted mb-3"><?= e($user['email']); ?></p>

                <span class="badge bg-secondary mb-3">
                    <?= $user['role'] === 'MANAGER' ? 'Menedżer' : ($user['role'] === 'EMPLOYEE' ? 'Pracownik' : 'Klient') ?>
                </span>

                <hr class="text-muted">
                <p class="text-muted small mb-0">Dołączono: <?= date('d.m.Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Dane konta</h5>
                <div class="d-flex gap-2">
                    <a href="index.php?page=profile_edit" class="btn btn-sm btn-outline-primary">Edytuj dane</a>
                    <a href="index.php?page=password_change" class="btn btn-sm btn-outline-secondary">Zmień hasło</a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Imię</div>
                    <div class="col-sm-8 fw-medium"><?= e($user['first_name']); ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Nazwisko</div>
                    <div class="col-sm-8 fw-medium"><?= e($user['last_name']); ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Adres e-mail</div>
                    <div class="col-sm-8 fw-medium"><?= e($user['email']); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 text-muted">Numer telefonu</div>
                    <div class="col-sm-8 fw-medium"><?= !empty($user['phone_number']) ? e($user['phone_number']) : '<em>Brak podanego numeru</em>'; ?></div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Książka adresowa</h5>
                <button type="button" class="btn btn-sm btn-primary">Dodaj nowy adres</button>
            </div>
            <div class="card-body p-4">
                <?php
                // Dekodujemy JSONB z bazy, jeśli istnieje. Załóżmy, że podano do widoku z ProfileController.
                $addresses = !empty($user['addresses']) ? json_decode($user['addresses'], true) : [];
                require BASE_PATH . '/views/partials/profile/address_list.php';
                ?>
            </div>
        </div>

    </div>
</div>
