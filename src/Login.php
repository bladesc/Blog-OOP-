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

    private $errorMessages = [];

    private $textMessages = [
        "E-mail doesn't exist",
        "Incorrect password"
    ];

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
            $this->addMessage($this->textMessages[0]);
        } else {
            $user = $this->db->getRecords();
            if (password_verify($this->user->getPassword(), $user['password'])) {

                $userSession = ['id' => $user['id'], 'email' => $user['email'], 'login' => $user['login']];
                $this->session->setSession('loggedUser', $userSession);
                return $user;
            } else {
                $this->addMessage($this->textMessages[2]);
            }
        }
    }

    public function addMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    public function showMessage()
    {
        return $this->errorMessages;
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