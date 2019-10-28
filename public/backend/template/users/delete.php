<?php

use Blog\Validate;
use Blog\Session;
use Blog\Redirect;
use Blog\Db;
use Blog\User;

//delete
if (isset($_POST['delete'])) {
    $validate = new Validate();
    $id = $validate->validateId($_POST['id']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('users.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $user = new User($db);
    $user->delete($id);

    if (!empty($user->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('users.php', $user->showMessage(), $session);
    }

    Redirect::redirectTo('users.php', ['delete successfully'], $session);
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
