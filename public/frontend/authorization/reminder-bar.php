<?php

use Blog\Validate;
use Blog\Db;
use Blog\Reminder;

if (isset($_GET['remind']) && isset($_GET['email'])) {
    $validate = new Validate();
    $hashString = $validate->validateValue($_GET['remind']);
    $email = $validate->validateEmail($_GET['email']);

    if (!$validate->showMessage()) {
        $db = new Db;
        $reminder = new Reminder($db);
        if ($reminder->checkHash($_GET['remind'], $_GET['email'])) {
            $formVisible = ['email' => $_GET['email'], 'hash' => '$_GET["remind"]'];
        }
    }

}
?>
<div id="login">
    <h3>Change password</h3>
    <?php if ($formVisible): ?>
        <form method="post" action="">

            <input type="hidden" name="hash" required value="<?= $formVisible['hash'] ?>">
            <input type="hidden" name="email" value="$formVisible['email']" required>
            <div>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" value="">
            </div>
            <div>
                <label for="provePassword">Prove of password: </label>
                <input type="password" name="provePassword" id="provePassword" value="">
            </div>
            <button type="submit" name="change">Change password</button>
        </form>
    <?php else: ?>
<!--//header index or 404-->
    <?php endif; ?>
</div>