<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 01:44
 */

namespace Blog;

class Login
{
    private $db;
    private $user;
    private $session;

    public function __construct(Db $db, User $user, Session $session)
    {
        $this->db = $db;
        $this->user = $user;
        $this->session = $session;
    }

    public function logIn()
    {
        echo $this->user->getEmail();
        $this->db->prepare("SELECT * FROM users WHERE email = '{$this->user->getEmail()}'");
        $this->db->execute();
        if ($this->db->getRowCount() === 0) {
            return 0;
        }
        else {
            return $this->db->getRecords();
        }

    }

    public function logOut()
    {

    }
}