<?php
use Blog\Db;
use Blog\Helper;
use Blog\Category;

//#CATEGORIES
$db = new Db;
$category = new Category($db);
$categories = $category->getAll(1);
?>


<div id="categories">
    <h3>Menu</h3>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <a href="category.php?category=<?= $category['id'] ?>"><?= $category['name'] ?></a>
                <span><?= $category['entries'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
