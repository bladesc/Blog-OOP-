<?php

require __DIR__ . '/../../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;
use Blog\Helper;

//#ENTRIES#
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getEntries();

?>

<?php include 'login-bar.php' ?>

<?php foreach ($entries as $entry): ?>
    <div><?= $entry['id'] ?></div>
    <div><?= $entry['title'] ?></div>
    <div><?= Helper::trimText($entry['description'], 2) ?></div>
    <div><?= Helper::dateOutput($entry['created_at']) ?></div>
    <div><?= Helper::dateOutput($entry['modified_at']) ?></div>
    <div>
        <form method="get" action="entry/entry-view.php">
            <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
            <button type="submit">More</button>
        </form>
    </div>
<?php endforeach; ?>




