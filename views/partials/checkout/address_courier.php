<h5 class="mb-3 mt-4 border-top pt-3">Adres do wysyłki</h5>
<div class="row g-3">
    <div class="col-md-6">
        <label for="first_name" class="form-label">Imię</label>
        <input type="text" class="form-control" id="first_name" name="shipping[first_name]" required>
    </div>

    <div class="col-md-6">
        <label for="last_name" class="form-label">Nazwisko</label>
        <input type="text" class="form-control" id="last_name" name="shipping[last_name]" required>
    </div>

    <div class="col-12">
        <label for="street" class="form-label">Ulica i numer domu/mieszkania</label>
        <input type="text" class="form-control" id="street" name="shipping[street]" required>
    </div>

    <div class="col-md-4">
        <label for="zip_code" class="form-label">Kod pocztowy</label>
        <input type="text" class="form-control" id="zip_code" name="shipping[zip_code]" placeholder="00-000" required>
    </div>

    <div class="col-md-8">
        <label for="city" class="form-label">Miejscowość</label>
        <input type="text" class="form-control" id="city" name="shipping[city]" required>
    </div>

    <div class="col-12">
        <label for="phone" class="form-label">Telefon dla kuriera</label>
        <input type="text" class="form-control" id="phone" name="shipping[phone]" placeholder="123 456 789" required>
    </div>
</div>
