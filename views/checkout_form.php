<!-- views/checkout_form.php -->
<div class="checkout-container py-4">
    <h1>Kasa - Finalizacja zamówienia</h1>

    <p>Tryb:
        <strong>
            <?= isset($_SESSION['user_id']) ? 'Zalogowany Użytkownik' : 'Gość' ?>
        </strong>
    </p>

    <!-- 
      Ważne: Action prowadzi na razie do pustej strony lub odświeża tę samą, 
      żebyśmy mogli zobaczyć var_dump($_POST) 
    -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <form id="checkout-form" method="POST" action="index.php?page=checkout_form">

                <!-- SEKCJA 1: DOSTAWA -->
                <div class="card shadow-sm border-0 p-4 mb-4">
                    <h4 class="mb-3">1. Wybierz metodę dostawy</h4>

                    <div class="mb-3">
                        <label>
                            <input type="radio" name="delivery_method" value="courier" checked>
                            Kurier (InPost/DPD)
                        </label><br>
                        <label>
                            <input type="radio" name="delivery_method" value="paczkomat">
                            Paczkomat InPost
                        </label><br>
                        <label>
                            <input type="radio" name="delivery_method" value="pickup">
                            Odbiór osobisty w salonie
                        </label>
                    </div>

                    <!-- KONTENERY NA PARTIALE DOSTAWY -->
                    <div id="delivery-forms">
                        <!-- Kurier -->
                        <div id="form-courier" class="delivery-partial">
                            <?php include BASE_PATH . '/views/partials/checkout/address_courier.php'; ?>
                        </div>

                        <!-- Paczkomat -->
                        <div id="form-paczkomat" class="delivery-partial" style="display: none;">
                            <?php include BASE_PATH . '/views/partials/checkout/address_paczkomat.php'; ?>
                        </div>

                        <!-- Odbiór osobisty -->
                        <div id="form-pickup" class="delivery-partial" style="display: none;">
                            <p>Wybrałeś odbiór osobisty. Nie musisz podawać adresu.</p>
                        </div>
                    </div>
                </div>

                <!-- SEKCJA 2: PŁATNOŚĆ (Bez partiali, bo to tylko opcje) -->
                <div class="card shadow-sm border-0 p-4 mb-4">
                    <h4 class="mb-3">2. Wybierz metodę płatności</h4>

                    <label>
                        <input type="radio" name="payment_method" value="payu" checked>
                        Szybki przelew / BLIK (PayU)
                    </label><br>
                    <label>
                        <input type="radio" name="payment_method" value="bank_transfer">
                        Przelew tradycyjny
                    </label><br>
                    <label>
                        <input type="radio" name="payment_method" value="cash_on_delivery">
                        Płatność przy odbiorze
                    </label>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <?php include BASE_PATH . '/views/partials/checkout/checkout_summary.php'; ?>
        </div>
    </div>
</div>

<script src="js/checkout.js" defer></script>
