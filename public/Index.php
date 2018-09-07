<?php

require __DIR__ . '/../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;

//entries
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getEntries();

$oneEntry = $entry->getEntry(2);

//CRUD
//delete
if (isset($_POST['delete'])) {
    echo 'delete';
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
    <form method="post" action="">
        <input type="hidden" value="<?= $entry['id'] ?>" required>
        <button name="delete">Delete</button>
        <button name="modify">Modify</button>
    </form>
<?php endforeach; ?>




