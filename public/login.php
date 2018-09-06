<?php
require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Login;
use Blog\Session;
use Blog\User;

//user login
$db = new Db;
$user = new User;
$user->setEmail('info@epix3o.pl');
$user->setPassword('1');

$session = new Session;

$login = new Login($session);

print_r($login->logIn($db, $user));
print_r($login->showMessage());