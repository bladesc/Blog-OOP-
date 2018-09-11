<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 10.09.2018
 * Time: 22:36
 */

namespace Blog;

use Blog\Register;

class Reminder
{
    /**
     * Db object
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
     * Sessio nobject
     *
     * @var Session
     */
    private $session;
    /**
     * Mailer object
     *
     * @var Mailer \
     */
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

    /**
     * Reminder constructor.
     *
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        $this->db = $db;

    }

    /**
     * It add hash string to database and sends email with link
     *
     * @param User $user
     * @param Session $session
     * @param Mailer $mailer
     */
    public function sendRemind(User $user, Session $session, Mailer $mailer)
    {
        $this->session = $session;
        $this->user = $user;
        $this->mailer = $mailer;

        if ($this->userExist('users', $this->user->getEmail())) {
            $hash = $this->generateHash();
            if ($this->updateHash($hash)) {
                $link = $this->buildLink($hash, $this->user->getEmail());
                if ($this->sendEmail($this->user->getEmail(), $link)) {
                   //email was send successfully
                    //$this->addMessage($this->textMessages[2]);
                } else {
                    $this->addMessage($this->textMessages[1]);
                }
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    /**
     * It builds link for reminding e-mail
     *
     * @param string $hash
     * @param string $email
     * @return string
     */
    public function buildLink(string $hash, string $email): string
    {
        return $link = "http://localhost/Blog-OOP-/public/frontend/reminder.php?remind=$hash&email=$email";
    }

    /**
     * It prepare and sends email
     *
     * @param string $email
     * @param string $link
     * @return bool
     */
    public function sendEmail(string $email, string $link): bool
    {
        $this->mailer->setSender('admin@blogoop.pl');
        $this->mailer->setSubject('Change password');
        $this->mailer->setRecipients([$email]);
        $this->mailer->setMessage("Click link below to reset your password <br> <a href='$link'>Change password</a>");
        return $this->mailer->sendEmail();
    }


    /**
     * It updates hash string in database
     *
     * @param string $hash
     * @return bool
     */
    public function updateHash(string $hash): bool
    {
        $email = $this->user->getEmail();
        $updated_at = date("Y-m-d H:i:s");
        $this->db->prepare("UPDATE users SET remind_string = '$hash', updated_at = '$updated_at' WHERE email = '$email'");
        return ($this->db->execute());
    }

    public function checkHash(string $hash, string $email)
    {
        $this->db->prepare("SELECT * FROM `users` WHERE email='$email' AND remind_string = '$hash'");
        $this->db->execute();
        return $this->db->getRowCount() > 0 ? true : false;
    }

    /**
     * It generates unique hash string
     *
     * @return string
     */
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

    public function changePassword(User $user)
    {
        $this->user = $user;
        $email = $this->user->getEmail();
        $password = Register::generatePassword($this->user->getPassword());
        $updated_at = date("Y-m-d H:i:s");
        $this->db->prepare("UPDATE `users` SET `updated_at` = '$updated_at', `password` = '$password', `remind_string` = '' WHERE `email` = '$email'");
        $this->db->execute();
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