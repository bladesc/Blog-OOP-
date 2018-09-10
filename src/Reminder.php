<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 10.09.2018
 * Time: 22:36
 */

namespace Blog;


class Reminder
{
    private $db;
    private $user;
    private $session;
    private $mailer;


    private $errorMessages = [];

    /**
     * Array with bodies of messages
     *
     * @var array
     */
    private $textMessages = [
        "E-mail doesn't exist",
        "Errors occurred during sending e-mail",
        "E-mail was send successfully"
    ];

    public function __construct(Db $db, User $user, Session $session, Mailer $mailer)
    {
        $this->db = $db;
        $this->session = $session;
        $this->user = $user;
        $this->mailer = $mailer;
    }

    public function remind(): bool
    {
        if ($this->userExist('users', $this->user->getEmail())) {
            $hash = $this->generateHash();
            if ($this->insertHash($hash)) {
                $link = $this->buildLink($hash);
                if ($this->sendEmail($this->user->getEmail(), $link)) {
                   //email was send successfully
                    $this->addMessage($this->textMessages[2]);
                    return true;
                } else {
                    $this->addMessage($this->textMessages[1]);
                    return false;
                }
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    public function buildLink(string $hash): string
    {
        return $link = "http://localhost/Blog-OOP-/public/frontend/reminder.php?remind=$hash";
    }

    public function sendEmail(string $email, string $link): bool
    {
        $this->mailer->setSender('admin@blogoop.pl');
        $this->mailer->setSubject('Change password');
        $this->mailer->setRecipients([$email]);
        $this->mailer->setMessage("Click link below to reset your password <br> <a href='$link'>Change password</a>");
        return $this->mailer->sendEmail();
    }

    public function insertHash(string $hash): bool
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