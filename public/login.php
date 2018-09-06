<?php
require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Login;
use Blog\Session;
use Blog\User;
use Blog\Validate;
use Blog\Redirect;

$session = new Session;
if ($session->issetSession('messages')) {
    print_r($_SESSION);
}

$validate = new Validate;
$email = $validate->validateEmail('info@epixo.pl');
$password = $validate->validatePassword('22222');

if (!empty($validate->showMessage())) {
   $redirect = new Redirect;
   $session = new Session;
   $redirect->redirectBack($validate->showMessage(), $session);
}

$user = new User;
$user->setEmail($email);
$user->setPassword($password);

$session = new Session;
$login = new Login($session);

$db = new Db;
print_r($login->logIn($db, $user));
print_r($login->showMessage());