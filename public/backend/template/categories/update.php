<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 28.09.2018
 * Time: 22:06
 */

use Blog\Db;
use Blog\Category;
use Blog\Validate;
use Blog\Redirect;
use Blog\Session;

$db = new Db;
$category = new Category($db);
$categories = $category->getById($_GET['id']);


if (isset($_POST['update'])) {

    $validate = new Validate;
    $id = $validate->validateId($_POST['id']);
    $name = $validate->validateValue($_POST['name']);
    $enabled = $validate->validateId($_POST['enabled']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/backend/categories.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $categories = new Category($db);
    $categories->setId($id);
    $categories->setName($name);
    $categories->setEnabled($enabled);
    $categories->update();

    if (!empty($categories->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/backend/categories.php', $categories->showMessage(), $session);
    }

    Redirect::redirectTo('public/backend/categories.php', ['update successfully'], $session);
}
?>

<form method="POST" action="">
    <input type="hidden" readonly required name="id" value="<?= $categories['id'] ?>">
    <div>
        <label for="enabled">Turn on/off</label>
        <select name="enabled" id="enabled">
            <option value="1" <?php if ($categories['enabled']==1) { echo 'selected';} ?>>enabled</option>
            <option value="0" <?php if ($categories['enabled']==0) { echo 'selected';} ?>>disabled</option>
        </select>
    </div>
    <div>
        <label for="name">Category name</label>
        <input type="text" name="name" id="name" value="<?= $categories['name'] ?>" required>
    </div>
    <div>
        <button type="submit" name="update">Add</button>
    </div>
</form>
