<?php
use Blog\User;
use Blog\Validate;
use Blog\Db;
use Blog\Redirect;
use Blog\Session;

//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    $errors = $_SESSION['messages'];
    $session->deleteSession('messages');
}

if (isset($_POST['send'])) {

    $validate = new Validate;
    $email = $validate->validateEmail($_POST['email']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/frontend/remind.php', $validate->showMessage(), $session);
    }

    $user = new User;
    $user->setEmail($email);

    $db = new Db;
    $session = new Session;
    $remind = new Remind($user, $db, $session);
    $remind->remind();
}

?>

<form action="" method="post">
    <input type="email" placeholder="e-mail" id="email">
    <button type="submit" name="send">Send me remind</button>
</form>
