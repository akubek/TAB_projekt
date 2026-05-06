document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('product-container');
    if (!container) return;

    const variants = JSON.parse(container.dataset.variants);
    const defaultMainImage = container.dataset.mainImage;
    const priceTag = document.getElementById('current-price');
    const imageTag = document.getElementById('main-product-image');
    const thumbnailsContainer = document.getElementById('product-thumbnails');
    const stockTag = document.getElementById('stock-info');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    // NASZ "STAN" (State)
    let selectedAttributes = { color: null, size: null };
    let currentMatchedVariantId = null; // Przechowujemy ID zamiast w ukrytym inpucie!

    window.changeMainImage = function (src, clickedThumbElement) {
        imageTag.style.opacity = 0.5;
        setTimeout(() => {
            imageTag.src = src;
            imageTag.style.opacity = 1;
        }, 150);

        if (clickedThumbElement) {
            document.querySelectorAll('.thumbnail-img').forEach(th => {
                th.classList.remove('border-primary', 'border-2');
                th.classList.add('border-light');
            });
            clickedThumbElement.classList.remove('border-light');
            clickedThumbElement.classList.add('border-primary', 'border-2');
        }
    };

    function renderGallery(imagesArray) {
        if (!thumbnailsContainer) return;
        thumbnailsContainer.innerHTML = '';

        if (!imagesArray || imagesArray.length === 0) {
            imagesArray = [defaultMainImage];
        }

        changeMainImage(imagesArray[0], null);

        if (imagesArray.length > 1) {
            thumbnailsContainer.classList.remove('d-none');

            imagesArray.forEach((imgSrc, index) => {
                const img = document.createElement('img');
                img.src = imgSrc;
                img.className = `img-thumbnail thumbnail-img ${index === 0 ? 'border-primary border-2' : 'border-light'}`;
                img.style.cssText = 'width: 80px; height: 80px; object-fit: cover; cursor: pointer; flex-shrink: 0; transition: border-color 0.2s;';

                img.addEventListener('click', function () {
                    changeMainImage(imgSrc, this);
                });

                thumbnailsContainer.appendChild(img);
            });
        } else {
            thumbnailsContainer.classList.add('d-none');
        }
    }
    // 1. ODCZYTYWANIE URL
    const urlParams = new URLSearchParams(window.location.search);
    const preselectedVariantId = urlParams.get('variant');

    if (preselectedVariantId) {
        const targetVariant = variants.find(v => v.id == preselectedVariantId);
        if (targetVariant) {
            const attrs = JSON.parse(targetVariant.attributes);
            if (attrs.color && attrs.color.key) selectedAttributes.color = attrs.color.key;
            else if (attrs.color) selectedAttributes.color = attrs.color;
            if (attrs.size) selectedAttributes.size = attrs.size;
        }
    }

    // 2. KLIKANIE CECH (UI)
    document.querySelectorAll('.variant-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const type = this.dataset.type;
            const val = this.dataset.value;

            document.querySelectorAll(`.${type}-btn`).forEach(b => {
                b.classList.remove('border-dark', 'border-3', 'active');
                if (b.classList.contains('btn-secondary')) {
                    b.classList.remove('btn-secondary', 'text-white');
                    b.classList.add('btn-outline-secondary');
                }
            });

            if (type === 'color') {
                this.classList.add('border-dark', 'border-3');
            } else {
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-secondary', 'text-white');
            }

            const label = this.dataset.label || val;
            document.getElementById(`selected-${type}-label`).innerText = label;

            selectedAttributes[type] = val;
            checkVariantMatch();
        });
    });

    // 3. WYSZUKIWANIE WARIANTU I AKTUALIZACJA "STANU"
    function checkVariantMatch() {
        if (!selectedAttributes.color || !selectedAttributes.size) return;

        const matchedVariant = variants.find(v => {
            const attrs = JSON.parse(v.attributes);
            const jsonColor = (attrs.color && attrs.color.key) ? attrs.color.key : attrs.color;
            return jsonColor === selectedAttributes.color && attrs.size === selectedAttributes.size;
        });

        if (matchedVariant) {
            // ZAPISUJEMY DO ZMIENNEJ W JS
            currentMatchedVariantId = matchedVariant.id;

            const basePrice = parseFloat(container.dataset.basePrice || 0);
            priceTag.innerText = (basePrice + parseFloat(matchedVariant.price_modifier)).toFixed(2) + ' zł';

            const images = JSON.parse(matchedVariant.images);
            renderGallery(images);

            stockTag.innerText = `Dostępność: ${matchedVariant.stock_quantity} szt.`;
            stockTag.className = "text-success fw-bold mt-2 mb-2";
            addToCartBtn.disabled = matchedVariant.stock_quantity <= 0;

        } else {
            // RESETUJEMY ZMIENNĄ
            currentMatchedVariantId = null;
            stockTag.innerText = "Ten wariant jest obecnie niedostępny";
            stockTag.className = "text-danger fw-bold mt-2 mb-2";
            addToCartBtn.disabled = true;
            renderGallery([defaultMainImage]);
        }
    }

    // 4. SYMULACJA KLIKNIĘĆ Z URL
    if (selectedAttributes.color) {
        const colorBtn = document.querySelector(`.color-btn[data-value="${selectedAttributes.color}"]`);
        if (colorBtn) colorBtn.click();
    }
    if (selectedAttributes.size) {
        const sizeBtn = document.querySelector(`.size-btn[data-value="${selectedAttributes.size}"]`);
        if (sizeBtn) sizeBtn.click();
    }

    // 5. DODAWANIE DO KOSZYKA Z UŻYCIEM ZMIENNEJ
    addToCartBtn.addEventListener('click', () => {
        // Bierzemy ID prosto ze zmiennej JS, a nie z HTML!
        const variantId = currentMatchedVariantId;

        if (!variantId) {
            alert('Proszę upewnić się, że wybrany wariant jest dostępny.');
            return;
        }

        let cart = {};
        const currentCookie = getCookie('cart');

        if (currentCookie) {
            try {
                cart = JSON.parse(currentCookie);
            } catch (e) { console.error("Błąd odczytu koszyka", e); }
        }

        if (cart[variantId]) {
            cart[variantId] += 1;
        } else {
            cart[variantId] = 1;
        }

        setCookie('cart', JSON.stringify(cart), 7);
        updateCartBadge();

        const originalText = addToCartBtn.innerText;
        addToCartBtn.innerText = "Dodano!";
        addToCartBtn.classList.add('btn-success');
        addToCartBtn.classList.remove('btn-primary');

        setTimeout(() => {
            addToCartBtn.innerText = originalText;
            addToCartBtn.classList.add('btn-primary');
            addToCartBtn.classList.remove('btn-success');
        }, 500);
    });
});
