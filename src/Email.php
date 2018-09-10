<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 10.09.2018
 * Time: 23:00
 */

namespace Blog;


class Email
{
    private $sender;
    private $recipients;
    private $content;

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}