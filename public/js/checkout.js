// public/js/checkout.js
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkout-form');
    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
    const partials = document.querySelectorAll('.delivery-partial');

    function updateDeliveryForm(selectedMethod) {
        // 1. Przejdź przez wszystkie partiale (kurier, paczkomat, pickup)
        partials.forEach(function (partial) {

            // Pobierz wszystkie inputy w danym partialu
            const inputs = partial.querySelectorAll('input');

            // 2. Jeśli ID tego partiala zgadza się z wybraną opcją (np. form-courier == form-courier)
            if (partial.id === 'form-' + selectedMethod) {
                // Pokaż partial
                partial.style.display = 'block';
                // Odblokowujemy pola w aktywnej zakładce (o ile nie mają twardej blokady data-locked)
                inputs.forEach(input => {
                    if (!input.hasAttribute('data-locked')) {
                        input.disabled = false;
                    }
                });
            } else {
                // Ukryj partial
                partial.style.display = 'none';
                // ZABLOKUJ inputy (przeglądarka zignoruje je przy wysyłaniu formularza!)
                inputs.forEach(input => input.disabled = true);
            }
        });
    }

    // Nasłuchuj zmian na radio buttonach
    deliveryRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            updateDeliveryForm(this.value);
        });
    });

    // Uruchom raz na starcie, żeby upewnić się, że stan jest poprawny
    const initialMethod = document.querySelector('input[name="delivery_method"]:checked');
    if (initialMethod) {
        updateDeliveryForm(initialMethod.value);
    }

    // ==========================================
    // WALIDACJA BOOTSTRAP (Czerwone ramki)
    // ==========================================
    if (form) {
        form.addEventListener('submit', function (event) {
            // Jeśli formularz ma błędy (np. zły format kodu pocztowego lub pusty email)
            if (!form.checkValidity()) {
                event.preventDefault(); // Zatrzymaj wysyłanie
                event.stopPropagation(); // Zatrzymaj inne skrypty

                // Płynnie przewiń ekran do pierwszego błędu
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            // Dodaj klasę Bootstrapa, która włącza pokazywanie stylów .invalid-feedback
            form.classList.add('was-validated');
        }, false);
    }
});
