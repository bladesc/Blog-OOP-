<?php
require __DIR__ . '/../../../vendor/autoload.php';
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

        $session = new Session;
        Redirect::redirectBack($validate->showMessage(), $session);
    }

    $user = new User;
    $user->setEmail($email);
    $user->setPassword($password);

    $session = new Session;
    $db = new Db;
    $login = new Login($session);
    $login->logIn($user, $db);

    if (!empty($login->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($login->showMessage(), $session);
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