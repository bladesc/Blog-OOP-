<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 28.09.2018
 * Time: 22:06
 */

use Blog\Db;
use Blog\Comment;
use Blog\Validate;
use Blog\Session;
use Blog\Redirect;

$db = new Db;
$comment = new Comment($db);
$comments = $comment->getById($_GET['id']);

if (isset($_POST['update'])) {

    $validate = new Validate;
    $id = $validate->validateId($_POST['id']);
    $content = $validate->validateValue($_POST['content']);
    $createdAt = $validate->validateValue($_POST['created_at']);
    $updatedAt = $validate->validateValue($_POST['updated_at']);


    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('comments.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $comment = new Comment($db);
    $comment->setId($id);
    $comment->setContent($content);
    $comment->setDateCreatedAt($createdAt);
    $comment->setDateUpdatedAt($updatedAt);
    $comment->update();

    if (!empty($comment->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('comments.php', $comment->showMessage(), $session);
    }

    Redirect::redirectTo('comments.php', ['update successfully'], $session);
}
?>

<form method="POST" action="">
    <input type="hidden" readonly required name="id" value="<?= $comments['id'] ?>">
    <div>
        <label for="created_at">Date created</label>
        <input name="created_at" id="created_at" required readonly type="datetime-local" value="<?= $comments['created_at'] ?>">
    </div>
    <div>
        <label for="updated_at">Date modified</label>
        <input name="updated_at" id="updated_at" required readonly type="datetime-local" value="<?= $comments['updated_at'] ?>">
    </div>
    <div>
        <label for="content">Comment content</label>
        <textarea name="content" id="content" required><?= $comments['content'] ?></textarea>
    </div>
    <div>
        <button type="submit" name="update">Update</button>
    </div>
</form>
