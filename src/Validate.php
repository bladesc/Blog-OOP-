<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:32
 */

namespace Blog;

class Validate
{
    private $errorMessages = [];

    private $textMessages = [
        "Incorrect e-mail"
    ];

    public function validateEmail($value)
    {
        $pattern = '/^([a-zA-Z]|-|_)+@[a-zA-Z]+\.[a-zA-Z]+$/';
        if (preg_match($pattern, $value)) {
            return $value;
        } else {
            $this->addMessage($this->textMessages[0]);
            return false;
        }
    }

    public function addMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    public function showMessage()
    {
        return $this->errorMessages;
    }

    public function validateValue($value)
    {
        return htmlspecialchars(trim($value));
    }
}