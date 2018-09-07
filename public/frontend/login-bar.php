<?php
use Blog\Session;
use Blog\Login;
use Blog\Redirect;

$session = new Session();
$loggedUser = Login::isLogged($session);

//#########LOGOUT
if (isset($_POST['logout'])) {
    $session = new Session;
    if (Login::isLogged($session)) {
        Login::logOut($session);
        Redirect::redirectBack();
    }
}

if (isset($_POST['login'])) {
    Redirect::redirectTo('authorization/login.php');
}
?>

<?php if ($loggedUser): ?>
    <div><?= $loggedUser['id'] ?></div>
    <div><?= $loggedUser['email'] ?></div>
    <div><?= $loggedUser['login'] ?></div>
    <div>
        <form method="POST" action="">
            <button type="submit" name="logout">Log out</button>
        </form>
    </div>
<?php else: ?>
    <div>
        <form method="POST" action="">
            <button type="submit" name="login">Log in</button>
        </form>
    </div>
<?php endif; ?>