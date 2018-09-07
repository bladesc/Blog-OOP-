<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Blog\Db;
use Blog\Register;
use Blog\Session;
use Blog\User;
use Blog\Validate;
use Blog\Redirect;


//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    print_r($_SESSION['messages']);
    $session->deleteSession('messages');
}

if (isset($_POST['register'])) {
    $validate = new Validate;
    $login = $validate->validateLogin($_POST['login']);
    $email = $validate->validateEmail($_POST['email']);
    $password = $validate->validatePassword($_POST['password']);

    if (!empty($validate->showMessage())) {
        $redirect = new Redirect;
        $session = new Session;
        $redirect->redirectBack($validate->showMessage(), $session);
    }

    $user = new User;
    $user->setLogin($login);
    $user->setEmail($email);
    $user->setPassword($password);

    $db = new Db;
    $session = new Session;
    $register = new Register($user, $db, $session);
    $register->register();

    if (!empty($register->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($register->showMessage(), $session);
    }
}


?>


<form method="post" action="">
    <input type="text" name="login" required placeholder="login">
    <input type="email" name="email" required placeholder="E-mail">
    <input type="password" name="password" required>
    <button type="submit" name="register">Register</button>
</form>
