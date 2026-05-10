// public/js/checkout.js
document.addEventListener('DOMContentLoaded', function () {
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
                // Odblokuj inputy (teraz przeglądarka będzie sprawdzać ich 'required')
                inputs.forEach(input => input.disabled = false);
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
    const initialMethod = document.querySelector('input[name="delivery_method"]:checked').value;
    updateDeliveryForm(initialMethod);
});
