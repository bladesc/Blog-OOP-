<?php
require __DIR__ .'/../vendor/autoload.php';
use Blog\Db;
use Blog\Register;
use Blog\Session;
use Blog\User;
use Blog\Validate;
use Blog\Redirect;




?>


<form method="post" action="">
    <input type="text" name="login" required placeholder="login">
    <input type="email" name="email" required placeholder="E-mail">
    <input type="password" name="password" required>
    <button type="submit" name="submit">Make account</button>
</form>
