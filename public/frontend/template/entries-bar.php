<?php
use Blog\Db;
use Blog\Entry;
use Blog\Helper;
use Blog\Paginator;

//#ENTRIES#
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getAll();

$paginator = new Paginator($entries, 2);
$entries = $paginator->getPaginateEntries($_GET['id']);
$navigation = $paginator->getNavigation();
?>

<div id="entries">
    <?php foreach ($entries as $entry): ?>
        <div class="box-entry">
            <div class="details">
                <div>Created at: <span><?= Helper::changeDateFormat($entry['created_at']) ?></span></div>
                <div>Category: <span><?= $entry['category'] ?></span></div>
                <div>Comments: <span><?= $entry['amount'] ?></span></div>
            </div>
            <h2><a href="entry-view.php?id=<?= $entry['id'] ?>"><?= $entry['title'] ?></a></h2>
            <p><?= Helper::trimText($entry['description'], 300) ?></p>

            <div>
                <form method="get" action="entry-view.php">
                    <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
                    <button type="submit">More</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ($navigation): ?>
        <?= $navigation?>
    <?php endif; ?>
</div>
