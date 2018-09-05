<?php

require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Entry;

/*$db = new Db;
$db->prepare('select * from news');
$db->execute();
$news = $db->getRecords();
echo $db->getRowCount();*/

$db = new Db;
$entry = new Entry($db);
$entries = $entry->getEntries();

//$news = $db->selectData('*', 'news', ['id','=','1'],null,['id','ASC'] );
$pas1 = password_hash('1as', PASSWORD_BCRYPT);
$pas2 = password_hash('1as', PASSWORD_BCRYPT);

if (password_verify('1as', $pas2)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

echo "<pre>";
print_r($entries);
echo "</pre>";