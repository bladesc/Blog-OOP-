<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 28.09.2018
 * Time: 22:06
 */

use Blog\Category;
use Blog\Db;
use Blog\Helper;
use Blog\Validate;
use Blog\Redirect;
use Blog\Session;

$db = new Db;
$category = new Category($db);
$categories = $category->getAll();

if (isset($_POST['create'])) {

    $validate = new Validate;
    $name = $validate->validateValue($_POST['name']);
    $enabled = $validate->validateId($_POST['enabled']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('categories.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $category = new Category($db);
    $category->setName($name);
    $category->setEnabled($enabled);
    $category->create();

    if (!empty($category->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('categories.php', $category->showMessage(), $session);
    }

    Redirect::redirectTo('categories.php', ['update successfully'], $session);
}
?>

<form method="POST" action="">
    <div>
        <label for="enabled">Turn on/off</label>
       <select name="enabled" id="enabled">
           <option value="1" selected>enabled</option>
           <option value="0">disabled</option>
       </select>
    </div>
    <div>
        <label for="name">Category name</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <button type="submit" name="create">Add</button>
    </div>
</form>
