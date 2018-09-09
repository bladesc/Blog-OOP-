<?php
use Blog\Db;
use Blog\Entry;
use Blog\Helper;

$category = (int) $_GET['category'];

$db = new Db;
$entry = new Entry($db);
$entries  = $entry->getByCategory($category);
?>

<div id="entries">
    <?php foreach ($entries as $entry): ?>
        <div class="box-entry">
            <div class="details">
                <div>Created at: <span><?= Helper::changeDateFormat($entry['created_at']) ?></span></div>
                <div>Category: <span><?= $entry['category'] ?></span></div>
                <div>Comments: <span><?= $entry['amount'] ?></span></div>
            </div>
            <h2><?= $entry['title'] ?></h2>
            <p><?= Helper::trimText($entry['description'], 300) ?></p>

            <div>
                <form method="get" action="../entry-view.php">
                    <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
                    <button type="submit">More</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
