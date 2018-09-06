<?php
require __DIR__ .'/../vendor/autoload.php';
use Blog\Login;
use Blog\Session;

//if logged
$session = new Session;
$login = new Login($session);
$isLogged = $login->isLogged();
if ($isLogged) {
    print_r($isLogged);
};