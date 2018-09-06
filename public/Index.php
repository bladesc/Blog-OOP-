<?php

require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Entry;

$db = new Db;
$entry = new Entry($db);
$entries = $entry->getEntries();

echo "<pre>";
print_r($entries);
echo "</pre>";






