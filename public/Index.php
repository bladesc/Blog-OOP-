<?php
require '../vendor/autoload.php';

$db = new Blog\Db;
$news = $db->selectData('*', 'news', ['id','=','1'],null,['id','ASC'] );
$db->closeConnection();

echo "<pre>";
print_r($news);
echo "</pre>";