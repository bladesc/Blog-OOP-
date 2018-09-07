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

    public function __construct(Session $session, Db $db)
    {
        if ($this->session == null) {
            $this->session = $session;
        }
        
        if ($this->db == null) {
            $this->db = $db;
        }

    }

    public function logIn(User $user): void
    {
        $this->user = $user;

        $existUser = $this->userExist('users', $this->user->getEmail());

        if (!$existUser) {
            $this->addMessage($this->textMessages[0]);
        } else {
            if ($this->verifyPassword($existUser['password'], $this->user->getPassword())) {
                $this->addToSession($existUser);
                $this->addMessage($this->textMessages[2]);
            } else {
                $this->addMessage($this->textMessages[1]);
            }
        }
    }

    public function addToSession($existUser)
    {
        $userSession = [
            'id' => $existUser['id'],
            'email' => $existUser['email'],
            'login' => $existUser['login']
        ];

        $this->session->setSession('loggedUser', $userSession);
    }

    public function verifyPassword(string $databasePassword, string $password): bool
    {
        return password_verify($password, $databasePassword) ? true : false;
    }

    public function userExist(string $table, string $email)
    {
        $this->db->prepare("SELECT * FROM $table WHERE email = '$email'");
        $this->db->execute();

        if ($this->db->getRowCount() === 0) {
            return false;
        } else {
            return $existUser = $this->db->getRecord();
        }
    }

    public static function logOut(Session $session): void
    {
        $session->deleteSession('userId');
        $session->destroySession();
    }

    public static function isLogged(Session $session)
    {
        if ($session->issetSession('loggedUser')) {
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