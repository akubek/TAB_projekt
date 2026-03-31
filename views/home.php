<h2>Wybierz dział</h2>

<?php if (empty($categories)): ?>
    <p>Brak kategorii w bazie.</p>
<?php else: ?>
    <ul style="list-style: none; padding: 0; display: flex; gap: 20px;">
        <?php foreach ($categories as $category): ?>
            <li style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; text-align: center;">
                <h3><?= htmlspecialchars($category['name']) ?></h3>
                <a href="index.php?page=category&id=<?= $category['id'] ?>" 
                   style="display: inline-block; padding: 10px 15px; background: #007BFF; color: white; text-decoration: none; border-radius: 4px;">
                   Wejdź
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>