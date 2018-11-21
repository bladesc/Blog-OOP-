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

if (isset($_POST['loginButton'])) {
    Redirect::redirectTo('public/frontend/login.php');
}
?>

<div id="box-login">
    <?php if ($loggedUser): ?>
        <div>
            Your e-mail: <span><?= $loggedUser['email'] ?></span>
        </div>
        <div>
            Your login: <span><?= $loggedUser['login'] ?></span>
        </div>
        <div>
            <form method="POST" action="">
                <button type="submit" name="logout">Log out</button>
            </form>
        </div>
    <?php else: ?>
        <div>
            <form method="POST" action="">
                <button type="submit" name="loginButton">Log in</button>
            </form>
        </div>
    <?php Redirect::redirectTo('public/frontend/login.php'); endif;  ?>
</div>