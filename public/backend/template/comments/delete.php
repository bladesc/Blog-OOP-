<?php

use Blog\Validate;
use Blog\Session;
use Blog\Redirect;
use Blog\Db;
use Blog\Comment;

//delete
if (isset($_POST['delete'])) {
    $validate = new Validate();
    $id = $validate->validateId($_POST['id']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($validate->showMessage(), $session);
    }

    $db = new Db;
    $comment = new Comment($db);
    $comment->delete($id);

    if (!empty($comment->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($comment->showMessage(), $session);
    }

    Redirect::redirectTo('public/backend/comments.php', 'delete successfully', $session);
}
?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" required>
    <div>
        Are you sure delete this item?
    </div>
    <div>
        <button type="submit" name="delete">Delete</button>
    </div>
</form>
