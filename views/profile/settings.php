<div class="container py-5">
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <?php
            $active_tab = 'settings';
            require BASE_PATH . '/views/partials/profile/sidebar.php';
            ?>
        </div>

        <div class="col-md-8 col-lg-9">
            <h2 class="mb-4">Ustawienia konta</h2>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Dane osobowe</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=profile_update">
                        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 border-top border-warning border-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Zmiana hasła</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=password_change">
                        <button type="submit" class="btn btn-warning">Zaktualizuj hasło</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
