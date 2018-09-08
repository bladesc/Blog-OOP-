<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Blog\Db;
use Blog\Entry;
use Blog\Helper;

if (isset($_GET['id'])) {
    //#ENTRIES#
    $id = (int) $_GET['id'];
    $db = new Db;
    $entry = new Entry($db);
    $entry = $entry->getById($id);
}

?>

<div><?= $entry['id'] ?></div>
<div><?= $entry['title'] ?></div>
<div><?= $entry['description'] ?></div>
<div><?= Helper::changeDateFormat($entry['created_at']) ?></div>
<div><?= Helper::changeDateFormat($entry['modified_at']) ?></div>
