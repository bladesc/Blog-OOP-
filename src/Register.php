<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:03
 */

namespace Blog;


class Register
{
    private $db;
    private $user;
    private $session;

    private $errorMessages = [];

    private $textMessages = [
        "E-mail exist in base",
        "Register successful"
    ];

    public function __construct(User $user, Db $db, Session $session)
    {
        $this->db = $db;
        $this->user = $user;
        $this->session = $session;
    }

    public function register()
    {
        $password = password_hash($this->user->getPassword(), PASSWORD_BCRYPT);

        if ($this->issetEmail($this->user->getEmail())) {
            $this->db->prepare("INSERT INTO users (email, password, login) 
                      VALUES ('".$this->user->getEmail()."','$password', '".$this->user->getLogin()."')");
            if ($this->db->execute()) {
                $this->addMessage($this->textMessages[1]);
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }

    }

    public function issetEmail($email)
    {
        $this->db->prepare("SELECT * FROM users WHERE email = '{$email}'");
        if ($this->db->execute()) {
            if ($this->db->getRowCount() > 0) {
                return false;
            } else {
                return true;
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
}