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
    $session->deleteSession('messages');
}

if (isset($_POST['submit'])) {
    $validate = new Validate;
    $email = $validate->validateEmail($_POST['email']);
    $password = $validate->validatePassword($_POST['password']);

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
    if (!empty($login->showMessage())) {
        $redirect = new Redirect;
        $session = new Session;
        $redirect->redirectBack($login->showMessage(), $session);
    }
}

?>


<form method="POST" action="">
    <input type="email" name="email" placeholder="Your e-mail" required>
    <input type="password" name="password" required>
    <button type="submit" name="submit">Zaloguj</button>
</form>
