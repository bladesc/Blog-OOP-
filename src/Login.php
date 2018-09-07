<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 01:44
 */
declare(strict_types=1);

namespace Blog;

class Login
{
    /**
     * Database object
     *
     * @var Db
     */
    private $db;
    /**
     * User object
     *
     * @var
     */
    private $user;
    /**
     * Session object
     *
     * @var Session
     */
    private $session;

    /**
     * Array of messages
     *
     * @var array
     */
    private $errorMessages = [];

    /**
     * Array with bodies of messages
     *
     * @var array
     */
    private $textMessages = [
        "E-mail doesn't exist",
        "Incorrect password",
        "Login successful"
    ];

    /**
     * Login constructor.
     *
     * @param Session $session
     * @param Db $db
     */
    public function __construct(Session $session, Db $db)
    {
        if ($this->session == null) {
            $this->session = $session;
        }

        if ($this->db == null) {
            $this->db = $db;
        }
    }

    /**
     * It login user
     *
     * @param User $user
     */
    public function logIn(User $user): void
    {
        $this->user = $user;

        if ($this->userExist('users', $this->user->getEmail())) {
            $existUser = $this->getUser('users', $this->user->getEmail());

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
    }

    /**
     * It adds user to session
     *
     * @param $existUser
     */
    public function addToSession($existUser)
    {
        $userSession = [
            'id' => $existUser['id'],
            'email' => $existUser['email'],
            'login' => $existUser['login']
        ];

        $this->session->setSession('loggedUser', $userSession);
    }

    /**
     * It verifies passed password width password from database
     *
     * @param string $databasePassword
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $databasePassword, string $password): bool
    {
        return password_verify($password, $databasePassword) ? true : false;
    }

    /**
     * IT checks that user e-mail exist in database
     *
     * @param string $table
     * @param string $email
     * @return bool
     */
    public function userExist(string $table, string $email): bool
    {
        $this->db->prepare("SELECT * FROM $table WHERE email = '$email'");
        $this->db->execute();

        return $this->db->getRowCount() === 0 ? false : true;
    }

    /**
     * It return user data from database. User must exists
     *
     * @param string $table
     * @param string $email
     * @return array
     */
    public function getUser(string $table, string $email)
    {
        $this->db->prepare("SELECT * FROM $table WHERE email = '$email'");
        $this->db->execute();

        return $this->db->getRecord();
    }

    /**
     * It's static method for logout user
     *
     * @param Session $session
     */
    public static function logOut(Session $session): void
    {
        $session->deleteSession('userId');
        $session->destroySession();
    }

    /**
     * It's static method for check that user id logged in
     *
     * @param Session $session
     * @return bool
     */
    public static function isLogged(Session $session)
    {
        if ($session->issetSession('loggedUser')) {
            return $_SESSION['loggedUser'];
        } else {
            return false;
        }
    }

    /**
     * It adds messages to array
     *
     * @param string $message
     */
    public function addMessage(string $message): void
    {
        $this->errorMessages[] = $message;
    }

    /**
     * It shows messages
     *
     * @return array
     */
    public function showMessage(): array
    {
        return $this->errorMessages;
    }
}