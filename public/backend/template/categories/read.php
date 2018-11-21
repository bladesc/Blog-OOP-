<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 26.09.2018
 * Time: 23:49
 */


use Blog\Db;
use Blog\Category;
use Blog\Redirect;
use Blog\Helper;

//#ENTRIES#
$db = new Db;
$category = new Category($db);
$categories = $category->getAll();

//modify
if (isset($_POST['create'])) {
    Redirect::redirectTo('public/backend/categories.php?action=create');
};

if (isset($_POST['update'])) {
    Redirect::redirectTo('public/backend/categories.php?action=update&id=' . $_POST["id"] . '');
}

if (isset($_POST['delete'])) {
    Redirect::redirectTo('public/backend/categories.php?action=delete&id=' . $_POST["id"] . '');
}

?>

<div id="add-new">
    <form method="POST" action="">
        <button type="submit" name="create">Add new</button>
    </form>
</div>
<table>
    <thead>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>enabled</th>
        <th>delete</th>
        <th>mofdify</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $category['id'] ?></td>
            <td><?= $category['name'] ?></td>
            <td><?= $category['enabled'] ?></td>
            <form method="POST" action="">
                <td>
                    <input type="hidden" name="id" value="<?= $category['id'] ?>" required>
                    <button type="submit" name="delete">Delete</button>
                </td>
                <td>
                    <button type="submit" name="update">Modify</button>
                </td>

            </form>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

