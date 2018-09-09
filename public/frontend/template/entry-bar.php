<?php
use Blog\Db;
use Blog\Entry;
use Blog\Helper;
use Blog\Redirect;

if (!isset($_GET['id'])) {
    Redirect::redirectTo('/../404.php');
    die("Id doesn't exist");
}
//#ENTRIES#
$id = (int)$_GET['id'];
$db = new Db;
$entry = new Entry($db);
$entry = $entry->getById($id);
?>

<div id="entries">
        <div class="box-entry">
            <div class="details">
                <div>Created at: <span><?= Helper::changeDateFormat($entry['created_at']) ?></span></div>
                <div>Category: <span><?= $entry['category'] ?></span></div>
            </div>
            <h2><?= $entry['title'] ?></h2>
            <p><?= Helper::trimText($entry['description'], 300) ?></p>

        </div>
</div>

<?php include 'comments-bar.php' ?>
