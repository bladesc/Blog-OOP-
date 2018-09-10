<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 10.09.2018
 * Time: 23:00
 */

namespace Blog;


class Mailer
{
    /**
     * Email sender
     *
     * @var string
     */
    private $sender = 'admin@bloogoop.pl';
    /**
     * Email recipients
     *
     * @var
     */
    private $recipients;
    /**
     * Email message
     *
     * @var
     */
    private $message;
    /**
     * Email subject
     *
     * @var
     */
    private $subject;

    /**
     * It sets email sender
     * @param string $sender
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * It sets email subject
     *
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * It sets email recipients
     *
     * @param array $recipients
     */
    public function setRecipients(array $recipients): void
    {
        $this->recipients = $recipients;
    }

    /**
     * It sets email message
     *
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * It returns email sender
     *
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * It returns email subject
     *
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * It returns email recipients
     *
     * @return array
     */
    public function getRecipient(): array
    {
        return $this->recipients[0];
    }

    /**
     * It returns email message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * It sends email
     *
     * @return bool
     */
    public function sendEmail()
    {
        $to = $this->getRecipient();
        $subject = $this->getSubject();
        $message = $this->getMessage();
        $headers = $this->getHeaders();

        return mail($to, $subject, $message, $headers);
    }

    /**
     * It returns headers for e-mail
     *
     * @return string
     */
    public function getHeaders()
    {
        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers
        $headers[] = 'To: <'.$this->getRecipient().'>';
        $headers[] = 'From: <'.$this->getSender().'>';

        return implode("\r\n", $headers);
    }

    public function sendEmails()
    {

    }
}