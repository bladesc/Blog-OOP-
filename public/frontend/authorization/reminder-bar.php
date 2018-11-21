<?php

use Blog\Validate;
use Blog\Db;
use Blog\Reminder;
use Blog\Session;
use Blog\Redirect;
use Blog\User;

//#REMIND
$formVisible = false;
if (isset($_GET['remind']) && isset($_GET['email'])) {
    $validate = new Validate();
    $hashString = $validate->validateValue($_GET['remind']);
    $email = $validate->validateEmail($_GET['email']);

    if (!$validate->showMessage()) {
        $db = new Db;
        $reminder = new Reminder($db);
        if ($reminder->checkHash($_GET['remind'], $_GET['email'])) {
            $formVisible = ['email' => $_GET['email'], 'hash' => $_GET['remind']];
        }
    }
}


//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    $errorsLogin = $_SESSION['messages'];
    $session->deleteSession('messages');
}

//#FORM REQUEST
if (isset($_POST['change'])) {
    $validate = new Validate();
    $password = $validate->validatePasswords($_POST['password'], $_POST['passwordProve']);
    $hashString = $validate->validateValue($_POST['hash']);
    $email = $validate->validateEmail($_POST['email']);

    if (!empty($validate->showMessage())) {
        $session = new Session;
        Redirect::redirectBack($validate->showMessage(), $session);
    }

    $db = new DB;
    $user = new User($db);
    $user->setEmail($email);
    $user->setPassword($password);

    $db = new DB;
    $reminder = new Reminder($db);
    $reminder->changePassword($user);

    if (!$reminder->showMessage()) {
        Redirect::redirectTo('public/frontend/index.php');
    } else {
        Redirect::redirectBack($validate->showMessage(), $session);
    }

}

?>
<?php if ($formVisible): ?>
    <div id="login">
        <h3>Change password</h3>

        <?php if (isset($errorsLogin)): ?>
            <div class="errors">
                <?php foreach ($errorsLogin as $errorLogin): ?>
                    <p><?= $errorLogin ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <input type="hidden" name="hash" value="<?= $formVisible['hash'] ?>" required>
            <input type="hidden" name="email" value="<?= $formVisible['email'] ?>" required>
            <div>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" value="">
            </div>
            <div>
                <label for="passwordProve">Prove of password: </label>
                <input type="password" name="passwordProve" id="passwordProve" value="">
            </div>
            <button type="submit" name="change">Change password</button>
        </form>
    </div>
<?php else: ?>
    <!--//header index or 404-->
<?php endif; ?>
