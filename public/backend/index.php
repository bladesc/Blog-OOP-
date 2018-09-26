<?php

require __DIR__ . '/../../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;
use Blog\Validate;
use Blog\Session;
use Blog\Redirect;
use Blog\Helper;

//#SESSION MESSAGES#
$session = new Session;
if ($session->issetSession('messages')) {
    print_r($_SESSION['messages']);
    $session->deleteSession('messages');
}

//#ENTRIES#
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getAll();

$oneEntry = $entry->getById(2);

//#CRUD#
//delete
if (isset($_POST['delete'])) {
    $validate = new Validate();
    $id = $validate->validateId($_POST['id']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($validate->showMessage(), $session);
    }

    $db = new Db;
    $entry = new Entry($db);
    $entry->delete($id);

    if (!empty($entry->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($entry->showMessage(), $session);
    }
}

//modify
if (isset($_POST['modify'])) {
    echo 'modify';
}

?>

<?php include 'template/layout-top-bar.php' ?>
<?php include 'template/login-bar.php' ?>

<div id="left-bar">
    <h2>MENU</h2>
    <ul>
        <li><a href="">entries</a></li>
        <li><a href="">categories</a></li>
        <li><a href="">comments</a></li>
        <li><a href="">users</a></li>
        <li><a href="">settings</a></li>

    </ul>

</div>
<div id="right-bar">
    <table>
        <thead>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>content</th>
            <th>created at</th>
            <th>updated at</th>
            <th>delete</th>
            <th>mofdify</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?= $entry['id'] ?></td>
                <td><?php echo Helper::trimText($entry['title'], 20); ?></td>
                <td><?php echo Helper::trimText($entry['description'], 50); ?></td>
                <td><?= $entry['created_at'] ?></td>
                <td><?= $entry['modified_at'] ?></td>
                <form method="POST" action="">
                    <td>
                        <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
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
<div id="bottom-bar"></div>






