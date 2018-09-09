<?php
use Blog\Db;
use Blog\Entry;
use Blog\Helper;
use Blog\Redirect;
use Blog\Comment;

if (!isset($_GET['id'])) {
    Redirect::redirectTo('/../404.php');
    die("Id doesn't exist");
}
//#ENTRIES#
$id = (int)$_GET['id'];
$db = new Db;
$entry = new Entry($db);
$entry = $entry->getById($id);

//#COMMENTS#
$db = new Db;
$comment = new Comment($db);
$comments = $comment->getByIdEntry($id);
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


<div>Comments <?= count($comments) ?></div>
<?php foreach ($comments as $comment): ?>
    <div><?= $comment['login'] ?></div>
    <div><?= $comment['content'] ?></div>
<?php endforeach; ?>

<?php if ($loggedUser): ?>
    <div>
        <form method="post" action="">
            <textarea name="content" placeholder="content..."></textarea>
            <button type="submit" name="create">Add comment</button>
        </form>
    </div>
<?php else: ?>
    <div>Comments are accessible only for logged users</div>
<?php endif; ?>
