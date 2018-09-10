<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 10.09.2018
 * Time: 22:36
 */

namespace Blog;


class Remind
{
    private $db;
    private $user;
    private $session;
    private $email;


    private $errorMessages = [];

    /**
     * Array with bodies of messages
     *
     * @var array
     */
    private $textMessages = [
        "E-mail doesn't exist"
    ];

    public function __construct(Db $db, User $user, Session $session, Email $email)
    {
        $this->db = $db;
        $this->session = $session;
        $this->user = $user;
        $this->email = $email;
    }

    public function remind()
    {
        if ($this->userExist('users', $this->user->getEmail())) {
            $hash = $this->generateHash();
            if ($this->insertHash($hash)) {
                if(!$this->email->sendEmail($this->user->getEmail())) {
                    $this->addMessage($this->textMessages[1]);
                }
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    public function insertHash(string $hash)
    {
        $this->db->prepare("INSERT INTO users (`hash_string`) VALUES ($hash) WHERE `email` = $this->user->getEmail()");
        return ($this->db->execute());
    }

    public function generateHash(): string
    {
        return md5(uniqid(rand(), true));;
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