<?php
require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Login;
use Blog\Session;
use Blog\User;
use Blog\Validate;

//user login
$db = new Db;
$user = new User;
$validate = new Validate;
$user->setEmail('info@epixo.pl');
$user->setPassword('2');

$session = new Session;

$login = new Login($session);

print_r($login->logIn($db, $user));
print_r($login->showMessage());