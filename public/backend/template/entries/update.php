<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 28.09.2018
 * Time: 22:06
 */

use Blog\Entry;
use Blog\Db;
use Blog\Category;
use Blog\Validate;
use Blog\Redirect;
use Blog\Session;

$db = new Db;
$entry = new Entry($db);
$entries = $entry->getById($_GET['id']);

$db = new Db;
$category = new Category($db);
$categories = $category->getAll();

if (isset($_POST['update'])) {

    $validate = new Validate;
    $id = $validate->validateId($_POST['id']);
    $title = $validate->validateValue($_POST['title']);
    $description = $validate->validateValue($_POST['description']);
    $createdAt = $validate->validateValue($_POST['created_at']);
    $modifiedAt = $validate->validateValue($_POST['modified_at']);
    $category = $validate->validateId($_POST['category']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('entries.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $entry = new Entry($db);
    $entry->setId($id);
    $entry->setTitle($title);
    $entry->setDescription($description);
    $entry->setDateCreatedAt($createdAt);
    $entry->setDateUpdatedAt($modifiedAt);
    $entry->setCategoryId($category);
    $entry->update();

    if (!empty($entry->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($entry->showMessage(), $session);
    }

    Redirect::redirectTo('entries.php', ['update successfully'], $session);
}
?>

<form action="" method="post">
    <input type="hidden" readonly required name="id" value="<?= $entries['id'] ?>">
    <div>
        <label for="date-created">Date created</label>
        <input name="created_at" id="date-created" required readonly type="datetime-local" value="<?= $entries['created_at'] ?>">
    </div>
    <div>
        <label for="date-modified">Date modified</label>
        <input name="modified_at" id="date-modified" required readonly type="datetime-local" value="<?= $entries['modified_at'] ?>">
    </div>
    <div>
        <label for="title">Title</label>
        <input id="title" type="text" name="title" placeholder="title" required value="<?= $entries['title'] ?>">
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="description"><?= $entries['description'] ?></textarea>
    </div>
    <div>
        <label for="category">Category</label>
        <select id="category" name="category">
            <?php foreach ($categories as $category): ?>
                <option <?php if ($category['id'] == $entries['id_category']) { echo 'selected'; }?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <button type="submit" name="update">Update</button>
    </div>
</form>
