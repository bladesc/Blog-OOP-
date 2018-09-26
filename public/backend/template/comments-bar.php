<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 26.09.2018
 * Time: 23:49
 */

use Blog\Db;
use Blog\Comment;
use Blog\Helper;

$db = new Db;
$comment = new Comment($db);
$comments = $comment->getAll();
?>


<div id="right-bar">
    <div id="add-new">
        <form method="POST" action="">
            <button type="submit" name="addNew">Add new</button>
        </form>
    </div>

    <table>
        <thead>
        <tr>
            <th>id</th>
            <th>id user</th>
            <th>id entry</th>
            <th>content</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>delete</th>
            <th>mofdify</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment['id'] ?></td>
                <td><?= $comment['id_user'] ?></td>
                <td><?= $comment['id_entry'] ?></td>
                <td><?= Helper::trimText($comment['content'],80) ?></td>
                <td><?= $comment['created_at'] ?></td>
                <td><?= $comment['updated_at'] ?></td>
                <form method="POST" action="">
                    <td>
                        <input type="hidden" name="id" value="<?= $comment['id'] ?>" required>
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
