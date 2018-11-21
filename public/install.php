<?php
require __DIR__ . '/../vendor/autoload.php';

use \Blog\Installation;
use \Blog\Db;

$installation = new Installation(new Db);
if ($installation->showMessage()) {
   foreach ($installation->showMessage() as $message)
   {
       echo $message . "<br>";
   }
}