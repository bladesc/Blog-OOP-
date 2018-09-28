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

$db = new Db;
$category = new Category($db);
$categories = $category->getAll();
?>

<form action="" method="post">
    <div>
        <label for="date-created">Date created</label>
        <input id="date-created" required readonly type="datetime-local" value="<?php echo Helper::showNowDate(); ?>">
    </div>
    <div>
        <label for="date-modified">Date modified</label>
        <input id="date-modified" required readonly type="datetime-local" value="<?php echo Helper::showNowDate(); ?>">
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
        <button type="submit" name="create">Add new</button>
    </div>
</form>
