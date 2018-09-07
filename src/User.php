<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 02:01
 */

declare(strict_types=1);

namespace Blog;

class User
{
    private $id;
    private $login;
    private $email;
    private $password;

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
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

    public function getUsers()
    {
    }

    public function getUser()
    {
    }

    public function createUser()
    {
    }

    public function updateUser()
    {
    }

    public function deleteUser()
    {

    }

}