<?php
require_once BASE_PATH . '/views/partials/breadcrumb.php';
?>
<div class="row" id="product-container"
    data-variants='<?= e(json_encode($product['variants'])) ?>'
    data-base-price='<?= e($product['base_price']) ?>'
    data-main-image='<?= e($product['main_image'] ?? 'https://placehold.co/600x800') ?>'>
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="product-image-wrapper bg-light rounded shadow-sm d-flex justify-content-center align-items-center mb-3"
            style="aspect-ratio: 3/4; overflow: hidden; width: 100%;">

            <img id="main-product-image"
                src="<?= e($product['main_image'] ?? 'https://placehold.co/600x800') ?>"
                alt="<?= e($product['name']) ?>"
                style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s ease-in-out;">
        </div>

        <div id="product-thumbnails" class="d-flex gap-2 overflow-x-auto pb-2 d-none" style="scrollbar-width: thin;">
            <!--created in js -->
        </div>
    </div>
    <div class="col-md-6">
        <h1><?= e($product['name']) ?></h1>
        <h2 id="current-price" class="text-primary"><?= number_format($product['base_price'], 2) ?> zł</h2>

        <div class="mt-4" id="variant-selection-area">
            <?php if (!empty($productAttrs['available_colors'])): ?>
                <h5>Kolor: <span id="selected-color-label" class="text-muted fw-normal">Wybierz</span></h5>
                <div class="d-flex gap-2 mb-3" id="color-selectors">
                    <?php foreach ($productAttrs['available_colors'] as $colorKey):
                        $colorData = $colorsDict[$colorKey] ?? ['name' => $colorKey, 'hex' => '#ccc'];
                    ?>
                        <button type="button" class="btn border border-secondary rounded-circle variant-btn color-btn p-0"
                            style="width: 35px; height: 35px; background-color: <?= e($colorData['hex']) ?>;"
                            data-type="color"
                            data-value="<?= e($colorKey) ?>"
                            data-label="<?= e($colorData['name']) ?>"
                            title="<?= e($colorData['name']) ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($productAttrs['available_sizes'])): ?>
                <h5>Rozmiar: <span id="selected-size-label" class="text-muted fw-normal">Wybierz</span></h5>
                <div class="d-flex gap-2 mb-3" id="size-selectors">
                    <?php foreach ($productAttrs['available_sizes'] as $size): ?>
                        <button type="button" class="btn btn-outline-secondary variant-btn size-btn"
                            data-type="size"
                            data-value="<?= e($size) ?>">
                            <?= e($size) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <p id="stock-info">Dostępność: Wybierz wariant</p>
            <button id="add-to-cart-btn" class="btn btn-primary btn-lg">Dodaj do koszyka</button>
        </div>
    </div>
</div>
<hr class="my-5">

<div class="row mb-5" id="reviews">
    <div class="col-md-8 mx-auto">
        <h3 class="mb-4">Opinie o produkcie</h3>
        <?php if (isset($_GET['status']) && $_GET['status'] === 'review_added'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Dziękujemy! Twoja opinia została pomyślnie dodana.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($ratingData['review_count'] > 0): ?>
            <div class="d-flex align-items-center mb-4">
                <h2 class="text-warning mb-0 me-2">★ <?= $ratingData['avg_rating'] ?></h2>
                <span class="text-muted">(Liczba opinii: <?= $ratingData['review_count'] ?>)</span>
            </div>
        <?php else: ?>
            <p class="text-muted">Ten produkt nie ma jeszcze żadnych opinii. Bądź pierwszy!</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($hasReviewed): ?>
                <div class="alert alert-success shadow-sm mb-5 border-0">
                    <h5 class="alert-heading fw-bold mb-1">Dziękujemy!</h5>
                    Dodałeś już opinię o tym produkcie. Możesz ją usunąć poniżej, jeśli chcesz napisać nową.
                </div>
            <?php else: ?>
                <div class="card shadow-sm mb-5 border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Napisz swoją opinię</h5>
                        <form action="index.php?page=add_review" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Twoja ocena</label>
                                <select name="rating" class="form-select" required>
                                    <option value="5">★★★★★ (5/5) - Rewelacja!</option>
                                    <option value="4">★★★★☆ (4/5) - Bardzo dobry</option>
                                    <option value="3">★★★☆☆ (3/5) - Przeciętny</option>
                                    <option value="2">★★☆☆☆ (2/5) - Słaby</option>
                                    <option value="1">★☆☆☆☆ (1/5) - Tragedia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Komentarz</label>
                                <textarea name="comment" class="form-control" rows="3" placeholder="Co myślisz o tym produkcie?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Dodaj opinię</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info shadow-sm mb-5 border-0">
                <a href="index.php?page=login" class="fw-bold text-info-emphasis">Zaloguj się</a>, aby móc dodać opinię o tym produkcie.
            </div>
        <?php endif; ?>

        <div class="reviews-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="card mb-4 border-0 shadow-sm rounded">
                        <div class="card-body p-4 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="fw-bold fs-5"><?= htmlspecialchars($review['first_name']) ?></span>

                                    <?php if ($review['is_verified']): ?>
                                        <span class="badge bg-success ms-2"><small>✓ Zweryfikowany zakup</small></span>
                                    <?php endif; ?>
                                </div>
                                <span class="text-warning fs-5">
                                    <?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?>
                                </span>
                            </div>

                            <p class="mb-3"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>

                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <small class="text-muted"><?= date('d.m.Y', strtotime($review['created_at'])) ?></small>

                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
                                    <div>
                                        <form action="index.php?page=delete_review" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę opinię?');">
                                            <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Usuń</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>
