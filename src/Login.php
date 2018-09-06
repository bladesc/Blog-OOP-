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
            return false;
        } else {
            $user = $this->db->getRecords();
            $userSession = ['id' => $user['id'], 'email' => $user['email'], 'login' => $user['login']];
            if (password_verify($this->user->getPassword(), $user['password'])) {
                $this->session->setSession('loggedUser', $userSession);
                return $user;
            } else {
                $this->session->setSession('message', 'Login error');
                return false;
            }
        }
    }

    public function logOut()
    {
        $this->session->deleteSession('userId');
        $this->session->destroySession();
    }

    public function isLogged()
    {
        if ($this->session->issetSession('loggedUser')) {
            return $_SESSION['loggedUser'];
        } else {
            return false;
        }
    }
}