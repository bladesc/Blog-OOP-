<?php

require __DIR__ . '/../../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;
use Blog\Helper;

$category = (int) $_GET['category'];

$db = new Db;
$entry = new Entry($db);
$entries  = $entry->getByCategory($category);

?>

<?php foreach ($entries as $entry): ?>
    <div><?= $entry['id'] ?></div>
    <div><?= $entry['title'] ?></div>
    <div><?= Helper::trimText($entry['description'], 300) ?></div>
    <div><?= Helper::changeDateFormat($entry['created_at']) ?></div>
    <div><?= Helper::changeDateFormat($entry['modified_at']) ?></div>
    <div>
        <form method="get" action="entry/entry-view.php">
            <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
            <button type="submit">More</button>
        </form>
    </div>
<?php endforeach; ?>

