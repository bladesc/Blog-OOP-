<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 02:01
 */

declare(strict_types=1);

namespace Blog;

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * It sets session for passed key and value
     *
     * @param $key
     * @param $value
     */
    public function setSession($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * It deletes session for passed key
     * @param $key
     */
    public function deleteSession($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * It checks that session for passed key exist
     *
     * @param $key
     * @return bool
     */
    public function issetSession($key): bool
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    /**
     * It destroys session
     */
    public function destroySession(): void
    {
        session_destroy();
    }
}