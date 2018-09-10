<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:32
 */

declare(strict_types=1);

namespace Blog;

class Validate
{
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
        "Incorrect e-mail",
        "Incorrect password",
        "Incorrect login",
        "Incorrect id"
    ];

    /**
     * It validates passed value
     *
     * @param $value
     * @return bool|string
     */
    public function validateEmail($value)
    {
        $value = $this->validateValue($value);

        $pattern = '/^([a-zA-Z]|-|_|\.)+@[a-zA-Z]+\.[a-zA-Z]+$/';
        if (preg_match($pattern, $value)) {
            return $value;
        } else {
            $this->addMessage($this->textMessages[0]);
            return false;
        }
    }

    /**
     * It validate passed login (only alphabetic and numeric characters and length between 2-20)
     *
     * @param $value
     * @return bool|string
     */
    public function validateLogin($value)
    {
        $value = $this->validateValue($value);

        $pattern = '/^([a-zA-Z]|[0-9]){5,20}$/';
        if (preg_match($pattern, $value)) {
            return $value;
        } else {
            $this->addMessage($this->textMessages[2]);
            return false;
        }
    }

    /**
     * It validates passed password (only alphabetic and numeric characters and length between 5-15)
     * @param $value
     * @return bool|string
     */
    public function validatePassword($value)
    {
        $value = $this->validateValue($value);

        $pattern = '/^([a-zA-Z]|[0-9]){5,15}$/';
        if (preg_match($pattern, $value)) {
            return $value;
        } else {
            $this->addMessage($this->textMessages[1]);
            return false;
        }
    }

    /**
     * It validate passed id (only numeric and characters length between 2-10)
     *
     * @param $value
     * @return bool|string
     */
    public function validateId($value)
    {
        $value = $this->validateValue($value);

        $pattern = '/^[0-9]{0,10}$/';
        if (preg_match($pattern, $value)) {
            return $value;
        } else {
            $this->addMessage($this->textMessages[3]);
            return false;
        }
    }

    /**
     * It validate passed value (cuts spaces from begin and end of value, changes html chars
     *
     * @param $value
     * @return string
     */
    public function validateValue($value)
    {
        return htmlspecialchars(trim($value));
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