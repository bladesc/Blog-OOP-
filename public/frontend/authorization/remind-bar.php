<?php

use Blog\User;
use Blog\Validate;
use Blog\Db;
use Blog\Redirect;
use Blog\Session;
use Blog\Reminder;
use Blog\Mailer;

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

    $mailer = new Mailer;

    $db = new Db;
    $session = new Session;
    $remind = new Reminder($db);
    $remind->sendRemind($user, $session, $mailer);

    if (!empty($remind->showMessage())) {
        $session = new Session;
        Redirect::redirectTo('public/frontend/remind.php', $remind->showMessage(), $session);
    } else {
        Redirect::redirectTo('public/frontend/index.php');
    }
}

?>
<div id="login">
    <h3>Remind password</h3>

    <?php if (isset($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="e-mail" id="email" required>
        </div>
            <button type="submit" name="send">Send me remind</button>
    </form>
</div>

<div class="login-button"><a href="login.php">Log in</a></div>
<div class="login-button"><a href="register.php">Register</a></div>