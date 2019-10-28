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
use Blog\Entry;
use Blog\Session;

$db = new Db;
$category = new Category($db);
$categories = $category->getAll();

if (isset($_POST['create'])) {

    $validate = new Validate;
    $title = $validate->validateValue($_POST['title']);
    $description = $validate->validateValue($_POST['description']);
    $createdAt = $validate->validateValue($_POST['created_at']);
    $modifiedAt = $validate->validateValue($_POST['modified_at']);
    $category = $validate->validateId($_POST['category']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirecttO('entries.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $entry = new Entry($db);
    $entry->setTitle($title);
    $entry->setDescription($description);
    $entry->setDateCreatedAt($createdAt);
    $entry->setDateUpdatedAt($modifiedAt);
    $entry->setCategoryId($category);
    $entry->create();

    if (!empty($entry->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('entries.php', $entry->showMessage(), $session);
    }

    Redirect::redirectTo('entries.php', ['update successfully'], $session);
}
?>

<form action="" method="post">
    <div>
        <label for="date-created">Date created</label>
        <input name="created_at" id="date-created" required readonly type="datetime-local" value="<?php echo Helper::showNowDate(); ?>">
    </div>
    <div>
        <label for="date-modified">Date modified</label>
        <input name="modified_at" id="date-modified" required readonly type="datetime-local" value="<?php echo Helper::showNowDate(); ?>">
    </div>
    <div>
        <label for="title">Title</label>
        <input id="title" type="text" name="title" placeholder="title" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="description"></textarea>
    </div>
    <div>
        <label for="category">Category</label>
        <select id="category" name="category">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>

            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <button type="submit" name="create">Add</button>
    </div>
</form>
