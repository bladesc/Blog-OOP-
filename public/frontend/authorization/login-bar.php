<?php

use Blog\Db;
use Blog\Login;
use Blog\Session;
use Blog\User;
use Blog\Validate;
use Blog\Redirect;

//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    $errorsLogin = $_SESSION['messages'];
    $session->deleteSession('messages');
}

//#########LOGIN
if (isset($_POST['login'])) {

    $validate = new Validate;
    $email = $validate->validateEmail($_POST['email']);
    $password = $validate->validatePassword($_POST['password']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('login.php', $validate->showMessage(), $session);
    }
    $db = new Db;
    $user = new User($db);
    $user->setEmail($email);
    $user->setPassword($password);

    $session = new Session;
    $db = new Db;
    $login = new Login($session);
    $login->logIn($user, $db);


    if (!empty($login->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('login.php', $login->showMessage(), $session);
    } else {
        Redirect::redirectTo('index.php');
    }
}


//#########LOGOUT
if (isset($_POST['logout'])) {
    $session = new Session;
    if (Login::isLogged($session)) {
        Login::logOut($session);
        Redirect::redirectBack();
    }
}

?>
<div id="login">
    <h3>Log in</h3>
    <?php if (isset($_SESSION['loggedUser'])): ?>
        <form method="POST" action="" autocomplete="on">
            <button type="submit" name="logout">Log out</button>
        </form>
    <?php else: ?>
        <?php if (isset($errorsLogin)): ?>
            <div class="errors">
                <?php foreach ($errorsLogin as $errorLogin): ?>
                    <p><?= $errorLogin ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div>
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" placeholder="Your e-mail" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div>
                <button type="submit" name="login">Log in</button>
            </div>
            <div>
                <a href="remind.php">Forgot password?</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<div class="login-button"><a href="register.php">Register</a></div>
