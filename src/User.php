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
    private $db;
    private $login;
    private $email;
    private $nickname;

    public function logIn(string $email, string $password)
    {

        $this->db->prepare('SELECT * FROM users WHERE email = "email"';
        $this->db->execute();
        return $this->db->getRecords();
    }

    public function logOut()
    {

    }

    public function validateData($data)
    {
        trim($data);
        return ($data);
    }
}