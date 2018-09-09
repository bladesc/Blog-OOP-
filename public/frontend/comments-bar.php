<?php

use Blog\Db;
use Blog\Comment;

//#COMMENTS#
$db = new Db;
$comment = new Comment($db);
$comments = $comment->getByIdEntry($id);
?>

<div id="comments">

    <h4>Comments <?= count($comments) ?></h4>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <div class="comment-login"><?= $comment['login'] ?></div>
            <div class="comment-content"><?= $comment['content'] ?></div>
        </div>
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
</div>