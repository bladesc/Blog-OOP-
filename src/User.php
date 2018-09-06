<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 02:01
 */

namespace Blog;

include 'Helper.php';
use Blog\Helper;

class User
{
    private $login;
    private $email;
    private $password;

    public function setLogin(string $login)
    {
        $this->login=Helper::validateValue($login);
    }

    public function setEmail(string $email)
    {
        $this->email=Helper::validateValue($email);
    }

    public function setPassword(string $password)
    {
        $this->password=Helper::validateValue($password);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getLogin()
    {
        return $this->login;
    }

}