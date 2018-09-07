<?php

require __DIR__ . '/../../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;

//#ENTRIES#
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getEntries();

?>

<?php include 'login-bar.php' ?>

<?php foreach ($entries as $entry): ?>
    <div><?= $entry['id'] ?></div>
    <div><?= $entry['title'] ?></div>
    <div><?= $entry['description'] ?></div>
    <div><?= $entry['created_at'] ?></div>
    <div><?= $entry['modified_at'] ?></div>
    <div>
        <form method="get" action="entry/entry-view.php">
            <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
            <button type="submit">More</button>
        </form>
    </div>
<?php endforeach; ?>




