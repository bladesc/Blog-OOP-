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
    private $sender;
    private $recipients;
    private $message;
    private $subject;

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getRecipient()
    {
        return $this->recipients[0];
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function sendEmail()
    {
        $to = $this->getRecipient();
        $subject = $this->getSubject();
        $message = $this->getMessage();
        $headers = $this->getHeaders();

        return mail($to, $subject, $message, $headers);
    }

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