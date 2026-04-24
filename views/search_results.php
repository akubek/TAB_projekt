<section class="search-header mb-5">
    <h1 class="text-break mb-3">
        Wyniki wyszukiwania dla frazy: <span class="text-primary">"<?= e($searchQuery) ?>"</span>
    </h1>

    <p class="text-muted">Znaleziono <?= count($products) ?> produktów.</p>
</section>

<?php require BASE_PATH . '/views/partials/product_grid.php'; ?>
