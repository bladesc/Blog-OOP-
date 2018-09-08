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
                <?= Helper::createLink($category['name'], $category['id'], "categories") ?>
                <span><?= $category['entries'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
