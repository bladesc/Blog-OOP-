<?php

require __DIR__ . '/../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;
use Blog\Validate;
use Blog\Session;
use Blog\Redirect;

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

<?php foreach ($entries as $entry): ?>
    <div><?= $entry['id'] ?></div>
    <div><?= $entry['title'] ?></div>
    <div><?= $entry['description'] ?></div>
    <div><?= $entry['created_at'] ?></div>
    <div><?= $entry['modified_at'] ?></div>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $entry['id'] ?>" required>
        <button type="submit" name="delete">Delete</button>
        <button type="submit" name="modify">Modify</button>
    </form>
<?php endforeach; ?>




