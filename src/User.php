<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 02:01
 */

namespace Blog;


class User
{
    private $login;
    private $email;
    private $password;

    public function setLogin(string $login)
    {
        $this->login=$this->validateData($login);
    }

    public function setEmail(string $email)
    {
        $this->email=$this->validateData($email);
    }

    public function setPassword(string $password)
    {
        $this->password=$this->validateData($password);
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


    function validateData($data)
    {
        return htmlspecialchars(trim($data));

    }
}