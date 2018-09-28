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

$db = new Db;
$entry = new Entry($db);
$entries = $entry->getById($_GET['id']);

$db = new Db;
$category = new Category($db);
$categories = $category->getAll();

?>

<form action="" method="post">
    <input type="hidden" readonly required name="id" value="<?= $entries['id'] ?>">
    <div>
        <label for="date-created">Date created</label>
        <input id="date-created" required readonly type="datetime-local" value="<?= $entries['created_at'] ?>">
    </div>
    <div>
        <label for="date-modified">Date modified</label>
        <input id="date-modified" required readonly type="datetime-local" value="<?= $entries['modified_at'] ?>">
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
                <option <?php if ($category['id'] === $entries['id_category']) { echo 'selected'; }?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <button type="submit" name="create">Add new</button>
    </div>
</form>
