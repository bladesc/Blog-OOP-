<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 28.09.2018
 * Time: 22:06
 */

use Blog\Db;
use Blog\User;
use Blog\Validate;
use Blog\Redirect;
use Blog\Session;
use Blog\Register;

if (isset($_POST['create'])) {

    $validate = new Validate;
    $login = $validate->validateLogin($_POST['login']);
    $email = $validate->validateEmail($_POST['email']);
    $password = $validate->validatePasswords($_POST['password'], $_POST['passwordProof']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/backend/users.php', $validate->showMessage(), $session);
    }

    $db = new Db;
    $user = new User($db);
    $user->setLogin($login);
    $user->setEmail($email);
    $user->setPassword($password);

    $db = new Db;
    $session = new Session;
    $register = new Register($user, $db, $session);
    $register->register();

    if (!empty($register->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/backend/users.php',$register->showMessage(), $session);
    }

    Redirect::redirectTo('public/backend/users.php', ['added successfully'], $session);
}
?>

<form method="POST" action="">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="login">Login</label>
        <input type="text" name="login" id="login" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="passwordProof">Proof of password</label>
        <input type="password" name="passwordProof" id="passwordProof" required>
    </div>
    <div>
        <button type="submit" name="create">Add</button>
    </div>
</form>
