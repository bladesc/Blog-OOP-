<?php

require __DIR__ . '/../../../vendor/autoload.php';

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
    $id = (int) $_GET['id'];
    $db = new Db;
    $entry = new Entry($db);
    $entry = $entry->getById($id);

    //#COMMENTS#
    $db = new Db;
    $comment = new Comment($db);
    $comments = $comment->getByIdEntry($id);
?>

<div><?= $entry['id'] ?></div>
<div><?= $entry['title'] ?></div>
<div><?= $entry['description'] ?></div>
<div><?= Helper::changeDateFormat($entry['created_at']) ?></div>
<div><?= Helper::changeDateFormat($entry['modified_at']) ?></div>

<div>Komentarze <?= count($comments) ?></div>
<?php foreach ($comments as $comment): ?>
    <div><?= $comment['content'] ?></div>
<?php endforeach; ?>

