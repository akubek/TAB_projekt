<!-- views/checkout_auth_gate.php -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-4">
            <h2>Wybierz sposób zamówienia</h2>
            <p class="text-muted">Aby kontynuować, zaloguj się lub kup bez zakładania konta.</p>
        </div>

        <!-- Sekcja Zaloguj / Zarejestruj -->
        <div class="col-md-5 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-light">
                <div class="card-body text-center p-4">
                    <h4 class="card-title mb-3">Mam już konto</h4>
                    <p class="card-text text-muted mb-4">Zaloguj się, aby szybciej złożyć zamówienie korzystając z zapisanych adresów.</p>

                    <div class="d-grid gap-2">
                        <!-- redirect=checkout_form, aby AuthController wiedział, gdzie wrócić -->
                        <a href="index.php?page=login&redirect=checkout_form" class="btn btn-primary btn-lg">Zaloguj się</a>
                        <a href="index.php?page=register&redirect=checkout_form" class="btn btn-outline-secondary">Nie mam konta - Zarejestruj się</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optyczny rozdzielacz dla większych ekranów -->
        <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
            <div class="vr h-50"></div>
        </div>

        <!-- Sekcja Gość -->
        <div class="col-md-5 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <h4 class="card-title mb-3">Kupuję jako gość</h4>
                    <p class="card-text text-muted mb-4">Nie musisz zakładać konta. Po prostu podaj dane do wysyłki w kolejnym kroku.</p>

                    <div class="d-grid gap-2 mt-auto">
                        <a href="index.php?page=checkout_form" class="btn btn-dark btn-lg">Kontynuuj bez konta</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
