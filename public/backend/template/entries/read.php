<?php

use Blog\Db;
use Blog\Entry;
use Blog\Redirect;
use Blog\Helper;

//#ENTRIES#
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getAll();

//modify
if (isset($_POST['add'])) {
    Redirect::redirectTo('public/backend/entries.php?action=add');
};

if (isset($_POST['update'])) {
    Redirect::redirectTo('public/backend/entries.php?action=update&id=' . $_POST["id"] . '');
}

if (isset($_POST['delete'])) {
    Redirect::redirectTo('public/backend/entries.php?action=delete&id=' . $_POST["id"] . '');
}


?>


<div id="add-new">
    <form method="POST" action="">
        <button type="submit" name="add">Add new</button>
    </form>
</div>
<table>
    <thead>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>content</th>
        <th>created at</th>
        <th>updated at</th>
        <th>delete</th>
        <th>modify</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
        <tr>
            <td><?= $entry['id'] ?></td>
            <td><?= Helper::trimText($entry['title'], 20); ?></td>
            <td><?= Helper::trimText($entry['description'], 70); ?></td>
            <td><?= $entry['created_at'] ?></td>
            <td><?= $entry['modified_at'] ?></td>
            <form method="get" action="">
                <td>
                    <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
                    <button type="submit" name="delete">Delete</button>
                </td>
                <td>
                    <button type="submit" name="update">Update</button>
                </td>

            </form>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

