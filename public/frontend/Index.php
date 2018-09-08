<?php

require __DIR__ . '/../../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;
use Blog\Helper;
use Blog\Category;

//#ENTRIES#
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getAll();

//#CATEGORIES

$db = new Db;
$category = new Category($db);
$categories = $category->getAll(1);

?>

<?php include 'login-bar.php' ?>

<?php foreach ($categories as $category): ?>
    <div><?= Helper::createLink($category['name'], $category['id'], "categories") ?></div>
<?php endforeach; ?>

<?php foreach ($entries as $entry): ?>
    <div><?= $entry['id'] ?></div>
    <div><?= $entry['title'] ?></div>
    <div><?= Helper::trimText($entry['description'], 300) ?></div>
    <div><?= Helper::changeDateFormat($entry['created_at']) ?></div>
    <div><?= Helper::changeDateFormat($entry['modified_at']) ?></div>
    <div><?= $entry['category'] ?></div>
    <div>Comments: <?= $entry['amount'] ?></div>
    <div>
        <form method="get" action="entry/entry-view.php">
            <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
            <button type="submit">More</button>
        </form>
    </div>
<?php endforeach; ?>




