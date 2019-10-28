<?php

use Blog\Validate;
use Blog\Session;
use Blog\Redirect;
use Blog\Db;
use Blog\Category;

//delete
if (isset($_POST['delete'])) {
    $validate = new Validate();
    $id = $validate->validateId($_POST['id']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('categories.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $category = new Category($db);
    $category->delete($id);

    if (!empty($category->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('categories.php', $category->showMessage(), $session);
    }

    Redirect::redirectTo('categories.php', ['delete successfully'], $session);
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
