<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:03
 */
declare(strict_types=1);

namespace Blog;


class Register
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
     * @var User
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
        "E-mail exist in base",
        "Register error"
    ];

    /**
     * Register constructor.
     *
     * @param User $user
     * @param Db $db
     * @param Session $session
     */
    public function __construct(User $user, Db $db, Session $session)
    {
        $this->db = $db;
        $this->user = $user;
        $this->session = $session;
    }

    /**
     * It registers user
     */
    public function register(): void
    {
        if (!$this->userExist('users', $this->user->getEmail())) {
            $password = self::generatePassword($this->user->getPassword());
            if (!$this->insertUser($password)) {
                $this->addMessage($this->textMessages[1]);
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    /**
     * It insert user to database
     *
     * @param string $password
     * @return mixed
     */
    public function insertUser(string $password): bool
    {
        $this->db->prepare(
            "INSERT INTO users (
                    email, 
                    password, 
                    login,
                    ) VALUES (
                    '" . $this->user->getEmail() . "',
                    '$password',
                    '" . $this->user->getLogin() . "')"
        );

        return $this->db->execute();
    }

    /**
     * It checks that user exist
     * @param string $table
     * @param string $email
     * @return bool
     */
    public function userExist(string $table, string $email): bool
    {
        $this->db->prepare("SELECT * FROM $table WHERE email = '$email'");
        $this->db->execute();

        return $this->db->getRowCount() > 0 ? true : false;
    }

    /**
     * It generates bcrypt password
     *
     * @param string $password
     * @return bool|string
     */
    public static function generatePassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
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