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
        "Incorrect password",
        "Login successful"
    ];

    public function __construct(User $user = null, Db $db = null, Session $session)
    {
        $this->session = $session;
        $this->db = $db;
        $this->user = $user;
    }

    public function logIn()
    {
        $this->db->prepare("SELECT * FROM users WHERE email = '{$this->user->getEmail()}'");

        if ($this->db->execute()) {
            if ($this->db->getRowCount() === 0) {
                $this->addMessage($this->textMessages[0]);
            } else {
                $user = $this->db->getRecord();
                if (password_verify($this->user->getPassword(), $user['password'])) {
                    $userSession = ['id' => $user['id'], 'email' => $user['email'], 'login' => $user['login']];
                    $this->session->setSession('loggedUser', $userSession);
                    $this->addMessage($this->textMessages[2]);
                } else {
                    $this->addMessage($this->textMessages[1]);
                }
            }
        }
    }


    public function logOut(): void
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

    public function addMessage(string $message): void
    {
        $this->errorMessages[] = $message;
    }

    public function showMessage(): array
    {
        return $this->errorMessages;
    }
}