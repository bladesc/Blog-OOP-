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

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function logIn(Db $db, User $user)
    {
        $this->db = $db;
        $this->user = $user;

        $this->db->prepare("SELECT * FROM users WHERE email = '{$this->user->getEmail()}'");
        $this->db->execute();
        if ($this->db->getRowCount() === 0) {
            return 0;
        }
        else {
            $user = $this->db->getRecords();
            $this->session->setSession('userId', $user['id']);
            return $user;
        }

    }

    public function logOut()
    {
        $this->session->deleteSession('userId');
        $this->session->destroySession();
    }
}