<?php

use Blog\Validate;
use Blog\Session;
use Blog\Redirect;
use Blog\Db;
use Blog\Entry;

//delete
if (isset($_POST['delete'])) {
    $validate = new Validate();
    $id = $validate->validateId($_POST['id']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('entries.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $entry = new Entry($db);
    $entry->delete($id);

    if (!empty($entry->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('entries.php', $entry->showMessage(), $session);
    }

    Redirect::redirectTo('entries.php', ['delete successfully'], $session);
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
