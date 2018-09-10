<?php

use Blog\Db;
use Blog\Register;
use Blog\Session;
use Blog\User;
use Blog\Validate;
use Blog\Redirect;


//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    $errors = $_SESSION['messages'];
    $session->deleteSession('messages');
}

if (isset($_POST['register'])) {
    $validate = new Validate;
    $login = $validate->validateLogin($_POST['login']);
    $email = $validate->validateEmail($_POST['email']);
    $password = $validate->validatePassword($_POST['password']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/frontend/register.php', $validate->showMessage(), $session);
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
        Redirect::redirectTo('public/frontend/register.php', $register->showMessage(), $session);
    } else {
        Redirect::redirectTo('public/frontend/index.php');
    }
    print_r($_SESSION);
}


?>

<div id="login">
    <h3>Register</h3>
    <?php if (isset($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <form method="post" action="">
        <div>
            <label for="login">Login</label>
            <input id="login" type="text" name="login" required placeholder="login">
        </div>
        <div>
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" required placeholder="E-mail">
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        <button type="submit" name="register">Register</button>
    </form>
</div>

<div class="login-button"><a href="login.php">Log in</a></div>