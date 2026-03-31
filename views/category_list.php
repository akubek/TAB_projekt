<h2>Dział: <?= htmlspecialchars($currentCategory['name']) ?></h2>
<p>Wybierz podkategorię:</p>

<ul style="list-style: none; padding: 0; display: flex; gap: 20px;">
    <?php foreach ($subcategories as $sub): ?>
        <li style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; text-align: center;">
            <h3><?= htmlspecialchars($sub['name']) ?></h3>
            <a href="index.php?page=category&id=<?= $sub['id'] ?>" 
               style="display: inline-block; padding: 10px 15px; background: #28A745; color: white; text-decoration: none; border-radius: 4px;">
               Wybierz
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<br>
<a href="javascript:history.back()">&laquo; Powrót</a>