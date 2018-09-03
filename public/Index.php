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


echo "<pre>";
print_r($entries);
echo "</pre>";