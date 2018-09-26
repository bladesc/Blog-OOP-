<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 26.09.2018
 * Time: 23:49
 */

use Blog\Db;
use Blog\User;

$db = new Db;
$user = new User();
$users = $user->getAll($db);
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
            <th>email</th>
            <th>login</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>delete</th>
            <th>modify</th>
            <th>change password</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['login'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td><?= $user['updated_at'] ?></td>
                <form method="POST" action="">
                    <td>
                        <input type="hidden" name="id" value="<?= $user['id'] ?>" required>
                        <button type="submit" name="delete">Delete</button>
                    </td>
                    <td>
                        <button type="submit" name="modify">Modify</button>
                    </td>
                    <td>
                        <button type="submit" name="changePassword">change password</button>
                    </td>
                </form>


            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
