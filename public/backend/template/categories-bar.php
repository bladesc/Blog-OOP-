<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 26.09.2018
 * Time: 23:49
 */

use Blog\Category;
use Blog\Db;

$db = new Db;
$category = new Category($db);
$categories = $category->getAll();
?>


<div id="right-bar">
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
                        <button type="submit" name="modify">Modify</button>
                    </td>

                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
