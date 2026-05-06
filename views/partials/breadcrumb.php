<?php if (!empty($breadcrumbs)): ?>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs as $index => $crumb): ?>

                <?php
                // Sprawdzamy, czy to ostatni element LUB czy nie podano URL
                if ($index === count($breadcrumbs) - 1 || empty($crumb['url'])):
                ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= htmlspecialchars($crumb['name']) ?>
                    </li>
                <?php else: ?>
                    <li class="breadcrumb-item">
                        <a href="<?= htmlspecialchars($crumb['url']) ?>">
                            <?= htmlspecialchars($crumb['name']) ?>
                        </a>
                    </li>
                <?php endif; ?>

            <?php endforeach; ?>
        </ol>
    </nav>
<?php endif; ?>
