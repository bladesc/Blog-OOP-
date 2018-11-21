<?php
use Blog\Db;
use Blog\Comment;
use Blog\Session;
use Blog\Redirect;

//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    $errors = $_SESSION['messages'];
    $session->deleteSession('messages');
}



//#COMMENTS#
$db = new Db;
$comment = new Comment($db);
$comments = $comment->getByIdEntry($id);

if (isset($_POST['send'])) {
    $db = new Db;
    $comment = new Comment($db);
    $comment->setAuthor($loggedUser['id']);
    $comment->setIdEntry($_POST['id_entry']);
    $comment->setContent($_POST['content']);
    $comment->create();

    if (!empty($comment->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($comment->showMessage(), $session);
    } else {
        Redirect::redirectBack();
    }
}

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
        <?php if (isset($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div>
            <form method="post" action="">
                <textarea name="content" placeholder="content..."></textarea>
                <input type="hidden" name="id_entry" required value="<?= $id ?>">
                <button type="submit" name="send">Add comment</button>
            </form>
        </div>
    <?php else: ?>
        <div>Comments are accessible only for logged users</div>
    <?php endif; ?>
</div>