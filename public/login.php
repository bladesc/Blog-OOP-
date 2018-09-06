<?php
require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Login;
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

//#########LOGIN
if (isset($_POST['login'])) {
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
    $login->logIn($db, $user);

    if (!empty($login->showMessage())) {
        $redirect = new Redirect;
        $session = new Session;
        $redirect->redirectBack($login->showMessage(), $session);
    }
}

//#########LOGOUT
if (isset($_POST['logout'])) {
    $session = new Session;
    if ($session->issetSession('loggedUser')) {
        $session->deleteSession('loggedUser');
        $redirect = new Redirect;
        $redirect->redirectBack();
    }
}

//SESSION
print_r($_SESSION);
?>

<?php if (isset($_SESSION['loggedUser'])): ?>
<form method="POST" action="">
    <button type="submit" name="logout">Log out</button>
</form>
<?php else: ?>

<form method="POST" action="">
    <input type="email" name="email" placeholder="Your e-mail" required>
    <input type="password" name="password" required>
    <button type="submit" name="login">Log in</button>
</form>
<?php endif; ?>