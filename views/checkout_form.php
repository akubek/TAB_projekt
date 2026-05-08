<!-- views/checkout_form.php -->
<div class="container my-5 text-center">
    <h2>Formularz Dostawy</h2>
    <p>Sukces! Jesteś w kroku dostawy - TODO.</p>
    <p>Tryb:
        <strong>
            <?= isset($_SESSION['user_id']) ? 'Zalogowany Użytkownik' : 'Gość' ?>
        </strong>
    </p>
    <!-- Tu w przyszłości zbudujesz ten właściwy formularz adresowy -->
    <a href="index.php?page=cart" class="btn btn-outline-secondary mt-3">Wróć do koszyka</a>
</div>
