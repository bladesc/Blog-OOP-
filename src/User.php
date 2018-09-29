<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 02:01
 */

declare(strict_types=1);

namespace Blog;

class User
{
    private $id;
    private $login;
    private $email;
    private $password;
    private $db;

    private $errorMessages = [];

    /**
     * Array with bodies of messages
     *
     * @var array
     */
    private $textMessages = [
        "Error deleting"
    ];

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getUsers()
    {
    }

    public function getUser()
    {
    }

    public function createUser()
    {
    }

    public function updateUser()
    {
    }

    public function deleteUser()
    {

    }

    public function getAll(Db $db)
    {
        $db->prepare(
            'SELECT * FROM users');

        if ($db->execute()) {
            return $db->getRecords();
        } else {
            return false;
        }
    }

    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM users where id = $id");
        if (!$this->db->execute()) {
            $this->addMessage($this->textMessages[0]);
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