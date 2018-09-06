<?php

require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Entry;
use Blog\User;
use Blog\Login;
use Blog\Session;

//entries
$db = new Db;
$entry = new Entry($db);
$entries = $entry->getEntries();

echo "<pre>";
print_r($entries);
echo "</pre>";
//endentries


//user login
$db = new Db;
$user = new User;
$user->setEmail('info@epixo.pl');
$user->setPassword('1');

$session = new Session;

$login = new Login($session);
print_r($login->logIn($db, $user));
print_r($_SESSION);
$pas1 = password_hash('1as', PASSWORD_BCRYPT);
$pas2 = password_hash('1as', PASSWORD_BCRYPT);

if (password_verify('1as', $pas2)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

