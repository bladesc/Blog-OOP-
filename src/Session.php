<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 02:01
 */
namespace Blog;

class Session
{
    private $sessionKey;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setSession($key, $value)
    {
        $this->sessionKey = $_SESSION[$key] = $value;
    }

    public function deleteSession($key)
    {
        $_SESSION = array();
    }

    public function issetSession($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }

    public function destroySession()
    {
        session_destroy();
    }
}