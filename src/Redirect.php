<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 21:33
 */
declare(strict_types=1);

namespace Blog;

class Redirect
{
    /**
     * It redirects back with possible message in session
     *
     * @param null $value
     * @param Session|null $session
     */
    public static function redirectBack($value = null, Session $session = null)
    {
        if (isset($value)) {
            $session->setSession('messages', $value);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     * It redirects to passed path with possible message in session
     *
     * @param $to
     * @param null $value
     * @param Session|null $session
     */
    public static function redirectTo($to, $value = null,  Session $session = null)
    {
        if (isset($value)) {
            $session->setSession('messages', $value);
        }
        header('Location: ' . $to);
    }
}